<?php

namespace KapitchiContact\Plugin;

use Zend\Di\Locator,
        Zend\EventManager\StaticEventManager,
        KapitchiIdentity\Form\Identity as IdentityForm;

class KapitchiIdentity implements \Zend\Mvc\LocatorAware {
    
    public function init($module) {
        StaticEventManager::getInstance()->attach('KapitchiIdentity\Service\Identity', 'create.pre', array($this, 'createPre'));
        StaticEventManager::getInstance()->attach('di', 'newInstance', array($this, 'createForm'));
    }
    
    public function createPre($e) {
        $data = $e->getParam('data');
        if(!empty($data['contact'])) {
            $service = $this->getLocator()->get('KapitchiContact\Service\Contact');
            $service->persist(array(
                'data' => $data['contact']
            ));
        }
    }
    
    public function createForm($e) {
        $instance = $e->getParam('instance');
        if($instance instanceof IdentityForm) {
            $newForm = $this->getLocator()->get('KapitchiContact\Form\Contact');
            $instance->addSubForm($newForm, 'contact');
        }
    }
    
    public function setLocator(Locator $locator) {
        $this->locator = $locator;
    }
    
    public function getLocator() {
        return $this->locator;
    }
}