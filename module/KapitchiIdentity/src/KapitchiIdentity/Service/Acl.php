<?php

namespace KapitchiIdentity\Service;

use KapitchiBase\Service\ServiceAbstract,
 Zend\EventManager\EventCollection,
 Zend\EventManager\EventManager,
    Zend\Acl\Acl as ZendAcl,
        Zend\EventManager\Event,
    Zend\Acl\Exception\InvalidArgumentException as ZendAclInvalidArgumentException;

class Acl extends ServiceAbstract {
    const ROLE_GUEST = 'guest';
    const ROLE_AUTH = 'auth';
    const ROLE_USER = 'user';
    
    protected $acl;
    
    public function isAllowed($resource = null, $privilege = null) {
        $acl = $this->getAcl();
        $roleId = $this->getRoleId();
        
        if(!$acl->hasResource($resource)) {
            
            //this is your chance to load resource ACL up!
            $this->triggerEvent('loadResource', array(
                'acl' => $acl,
                'role' => $roleId,
                'resource' => $resource,
                'privilage' => $privilege
            ));
            
            //persist (possibly) update ACL into cache mechanism e.g. session etc.
            $this->triggerEvent('cacheAcl', array(
                'acl' => $acl,
                'role' => $roleId,
                'resource' => $resource,
                'privilage' => $privilege
            ));
        }
        
        try {
            $ret = $acl->isAllowed($roleId, $resource, $privilege);
            
            return $ret;
        } catch(ZendAclInvalidArgumentException $e) {
            //in case there is still no resource/role
            return false;
        }
    }
    
    public function invalidateCache() {
        $this->triggerEvent('invalidateCache', array(
            'role' => $this->getRoleId(),
        ));
        
        $this->acl = null;
    }
    
    public function getRoles() {
        
    }
    
    protected function getRoleId() {
        $authService = $this->getLocator()->get('KapitchiIdentity\Service\Auth');
        return $authService->getRoleId();
    }
    
    protected function getAcl() {
        if($this->acl === null) {
            $result = $this->events()->trigger('loadAcl', $this, array(), function($ret) {
                return ($ret instanceof ZendAcl);
            });
            $acl = $result->last();
            if (!$acl instanceof ZendAcl) {
                //TODO proper exception
                throw new \Exception("No ACL can't be loaded");
            }
            
            $this->acl = $acl;
        }
        
        return $this->acl;
    }
    
    public function loadDefaultAcl(Event $e) {
        $acl = $this->getLocator()->get('Zend\Acl\Acl');
        
        //init default roles
        $acl->addRole(self::ROLE_GUEST);
        $acl->addRole(self::ROLE_AUTH, self::ROLE_GUEST);
        $acl->addRole(self::ROLE_USER, self::ROLE_GUEST);
        
        return $acl;
    }
    
    
    //event listeners
    public function loadSessionAcl(Event $e) {
        $mapper = $this->getLocator()->get('KapitchiIdentity\Model\Mapper\AclSession');
        $acl = $mapper->loadByRoleId($e->getParam('role'));
        return $acl;
    }
    
    public function persistSessionAcl(Event $e) {
        $mapper = $this->getLocator()->get('KapitchiIdentity\Model\Mapper\AclSession');
        return $mapper->persist($e->getParam('acl'), $e->getParam('role'));
    }
    
    public function invalidateSessionCache(Event $e) {
        $mapper = $this->getLocator()->get('KapitchiIdentity\Model\Mapper\AclSession');
        $mapper->invalidate($e->getParam('role'));
    }
    
    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     * 
     * @return EventCollection
     */
    public function events()
    {
        if (!$this->events instanceof EventCollection) {
            $this->setEventManager(new EventManager(array(__CLASS__, get_class($this))));
            $this->attachDefaultListeners();
        }
        return $this->events;
    }
    
    protected function attachDefaultListeners() {
        $events = $this->events();
        $events->attach('loadAcl', array($this, 'loadDefaultAcl'), -20);
        $events->attach('loadAcl', array($this, 'loadSessionAcl'), -10);
        
        $events->attach('cacheAcl', array($this, 'persistSessionAcl'), -10);
        
        $events->attach('invalidateCache', array($this, 'invalidateSessionCache'), -10);
    }
}