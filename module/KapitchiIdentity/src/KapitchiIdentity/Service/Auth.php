<?php

namespace KapitchiIdentity\Service;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService,
        Zend\Di\Locator,
    KapitchiIdentity\Model\AuthIdentity,
    Zend\Authentication\Adapter;

class Auth extends ZendAuthenticationService {
    
    protected $locator;

    public function authenticate(Adapter $adapter) {
        $result = $adapter->authenticate();

        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }

        if ($result->isValid()) {
            if($adapter instanceof Auth\IdentityResolver) {
                $authIdentity = $adapter->resolveAuthIdentity($result->getIdentity());
            }
            else {
                $authIdentity = new AuthIdentity($result->getIdentity(), 'guest-auth');
            }
            $this->getStorage()->write($authIdentity);
        }
    }
    
    /**
     * Clears the identity from persistent storage
     *
     * @return void
     */
    public function clearIdentity()
    {
        $this->getStorage()->clear();
        
        $acl = $this->getLocator()->get('KapitchiIdentity\Service\Acl');
        $acl->invalidateCache();
    }
    
    public function getRoleId() {
        if(!$this->hasIdentity()) {
            return 'guest';
        }
        
        $authIdentity = $this->getIdentity();
        $roleId = $authIdentity->getRoleId();
        if(empty($roleId)) {
            throw new \Exception("User has got no role, why???");
        }
        
        return $roleId;
    }
    
    public function getLocalIdentityId() {
        if(!$this->hasIdentity()) {
            throw new \Exception("User is not logged in");
        }
        
        $authIdentity = $this->getIdentity();
        $localId = $authIdentity->getLocalIdentityId();
        if(empty($localId)) {
            throw new \Exception("User has got no local identity");
        }
        
        return $localId;
    }
    
    public function setLocator(Locator $locator) {
        $this->locator = $locator;
    }
    
    public function getLocator() {
        return $this->locator;
    }
    
    
}