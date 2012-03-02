<?php

namespace KapitchiContact;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    KapitchiIdentity\Form\Identity as IdentityForm,
    Zend\EventManager\EventDescription as Event;

class Module implements AutoloaderProvider
{
    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'initPlugins'), 100);
    }
    
    public function initPlugins($e) {
        $app          = $e->getParam('application');
        $locator      = $app->getLocator();
        $plugin     = $locator->get('KapitchiContact\Plugin\KapitchiIdentity');
        
        $plugin->init($this);
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
