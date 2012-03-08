<?php

//error_reporting(E_ALL ^ E_NOTICE);

chdir(dirname(__DIR__));
require_once 'vendor/zf2/library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array('Zend\Loader\StandardAutoloader' => array()));

$appConfig = include 'config/application.config.php';

Zend\EventManager\StaticEventManager::getInstance()->attach('bootstrap', 'bootstrap', function(Zend\EventManager\Event $event) {
            //var_dump($event);
            //exit;
});

$listenerOptions  = new Zend\Module\Listener\ListenerOptions($appConfig['module_listener_options']);
$defaultListeners = new Zend\Module\Listener\DefaultListenerAggregate($listenerOptions);
$defaultListeners->getConfigListener()->addConfigGlobPath('config/autoload/*.config.php');

$moduleManager = new Zend\Module\Manager($appConfig['modules']);
$moduleManager->events()->attachAggregate($defaultListeners);
$moduleManager->loadModules();

// Create application, bootstrap, and run
$bootstrap   = new KapitchiBase\Mvc\Bootstrap($defaultListeners->getConfigListener()->getMergedConfig());
//$bootstrap   = new Zend\Mvc\Bootstrap($defaultListeners->getConfigListener()->getMergedConfig());
$application = new Zend\Mvc\Application;
$bootstrap->bootstrap($application);
$application->run()->send();



//$x = Zend\EventManager\StaticEventManager::getInstance();
//$x = $application->events();
$x = $moduleManager->events();
//var_dump($x);
exit;
var_dump($x->getEvents('bootstrap'));
$lists = $x->getListeners('bootstrap', 'bootstrap');
foreach($lists as $list) {
    $callback = $list->getCallback();
    //array
    if(is_array($callback)) {
        list($obj, $methodName) = $callback;
        $ref = new ReflectionMethod($obj, $methodName);
        var_dump($ref->getFileName());
        var_dump($ref->getStartLine());
        var_dump($ref->getEndLine());
        
        var_dump($ref->getNamespaceName());
        var_dump($ref->getDeclaringClass()->getName());
        var_dump($ref->getName());
        
        exit;
    }
    else {
        var_dump($callback);
        exit;
    }
}
exit;