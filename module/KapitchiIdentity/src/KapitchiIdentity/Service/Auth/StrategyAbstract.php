<?php

namespace KapitchiIdentity\Service\Auth;

use Zend\EventManager\EventCollection,
        Zend\Authentication\Result,
        Zend\Form\Form,
        KapitchiBase\Service\ServiceAbstract,
        KapitchiIdentity\Model\AuthIdentity;

abstract class StrategyAbstract extends ServiceAbstract implements Strategy {
    protected $listeners = array();
    
    public function attach(EventCollection $events)
    {
        $this->listeners[] = $events->attach('authenticate.init', array($this, 'init'));
    }
    
    abstract public function init($e);
    
//    public function resolveAuthIdentity($id) {
//        $params = array(
//            'identity' => $id
////        );
////        $result = $this->events()->trigger('resolveAuthIdentity', $this, $params, function($ret) {
////            return $ret instanceof AuthIdentity;
////        });
////        if($result->stopped()) {
////            return $result->last();
////        }
//        
//        $authId = new AuthIdentity($id, 'user', 1);
//        return $authId;
//    }
    
    
    public function detach(EventCollection $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}