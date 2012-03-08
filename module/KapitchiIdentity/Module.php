<?php

namespace KapitchiIdentity;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    Zend\EventManager\EventDescription as Event;

class Module implements AutoloaderProvider
{
    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'initBootstrap'));
    }
    
    public function initBootstrap($e) {
        $app          = $e->getParam('application');
        $locator      = $app->getLocator();
        
        $events = StaticEventManager::getInstance();
        $events->attach('KapitchiIdentity\Service\Acl', 'loadResource', function(Event $e) {
            $acl = $e->getParam('acl');
            $resource = $e->getParam('resource');
            
            $acl->addResource($resource);
            
            $acl->allow('user', $resource, null);
        });
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
