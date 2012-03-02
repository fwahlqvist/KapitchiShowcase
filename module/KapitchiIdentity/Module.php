<?php

namespace KapitchiIdentity;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider,
    KapitchiIdentity\Form\Identity as IdentityForm,
    Zend\EventManager\EventDescription as Event;

class Module implements AutoloaderProvider
{
    public function init(Manager $moduleManager)
    {
        StaticEventManager::getInstance()->attach('KapitchiIdentity\Service\Identity', 'create.pre', function($e) {
            $data = $e->getParam('data');
            
        });
        
        StaticEventManager::getInstance()->attach('di', 'newInstance', function($e) {
            $instance = $e->getParam('instance');
            if($instance instanceof IdentityForm) {
                $di = $e->getTarget();
                $newForm = new \Zend\Form\SubForm();
                $newForm->addElement('text', 'firstname');
                $newForm->addElement('text', 'surname');
                $instance->addSubForm($newForm, 'contact');
            }
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
