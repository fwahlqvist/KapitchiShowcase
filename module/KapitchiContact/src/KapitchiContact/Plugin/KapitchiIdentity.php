<?php

namespace KapitchiContact\Plugin;

use Zend\Di\Locator,
        Zend\EventManager\StaticEventManager,
        KapitchiIdentity\Form\Identity as IdentityForm;

class KapitchiIdentity implements \Zend\Mvc\LocatorAware {
    
    public function init($module) {
        $events = StaticEventManager::getInstance();
        $events->attach('KapitchiIdentity\Service\Identity', 'persist.post', array($this, 'createPost'));
        $events->attach('KapitchiIdentity\Service\Identity', 'persist.pre', array($this, 'createPre'));
        $events->attach('di', 'newInstance', array($this, 'createForm'));
    }
    
    public function createPre($e) {
        //$params = $e->getParams();
        //$params['identity']->setCreated('xxx');
        return array();
    }
    
    public function createPost($e) {
        $data = $e->getParam('data');
        if(!empty($data['contact'])) {
            $service = $this->getLocator()->get('KapitchiContact\Service\Contact');
            $ret = $service->persist($data['contact']);
            $identity = $e->getParam('identity');
            $identity->ext('KapitchiContact_Contact', $ret['contact']);
            //return $ret;
        }
    }
    
    public function createForm($e) {
        $instance = $e->getParam('instance');
        if($instance instanceof IdentityForm) {
            $newForm = $this->getLocator()->get('KapitchiContact\Form\Contact');
            $newForm->setIsArray(true);
            $extsForm = $instance->getExtsSubForm();
            $extsForm->addSubForm($newForm, 'KapitchiContact_Contact');
        }
    }
    
    public function setLocator(Locator $locator) {
        $this->locator = $locator;
    }
    
    public function getLocator() {
        return $this->locator;
    }
}