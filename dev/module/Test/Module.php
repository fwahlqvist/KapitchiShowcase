<?php

namespace Test;

use Zend\Module\Manager,
    Zend\Mvc\AppContext as Application,
    Zend\EventManager\StaticEventManager,
    Zend\EventManager\EventDescription as Event,
    Zend\Mvc\MvcEvent as MvcEvent,
    KapitchiBase\Module\ModuleAbstract,
    KapitchiIdentity\Service\Acl as AclService;

class Module extends ModuleAbstract {
    
    public function getDir() {
        return __DIR__;
    }
    
    public function getNamespace() {
        return __NAMESPACE__;
    }

    public function bootstrap(Manager $moduleManager, Application $app) {
        $locator      = $app->getLocator();
        
        
    }
    
}
