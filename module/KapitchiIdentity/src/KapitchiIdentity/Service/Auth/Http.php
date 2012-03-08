<?php

namespace KapitchiIdentity\Service\Auth;

use Zend\EventManager\EventCollection;

class Http implements Strategy {
    private $adapter;
    
    public function attach(EventCollection $events)
    {
        $this->listeners[] = $events->attach('authenticate.pre', array($this, 'preAuth'));
        $this->listeners[] = $events->attach('authenticate.post', array($this, 'postAuth'));
    }
    
    public function preAuth($e) {
        //TODO
        if(false) {
            return $this->getAdapter($e);
        }
    }
    
    public function postAuth($e) {
        $adapter = $e->getParam('adapter');
        if($adapter == $this->getAdapter($e)) {
            $result = $e->getParam('result');
            if(!$result->isValid()) {
                return $adapter->getResponse();
            }
        }
    }
    
    public function getAdapter($e) {
        if($this->adapter === null) {
            //return $e->getTarget()->redirect()->toRoute('kapitchiidentity');
            $cont = $e->getTarget();
            $adapter = $cont->getLocator()->get('Zend\Authentication\Adapter\Http');

            $res = new \Zend\Authentication\Adapter\Http\FileResolver('./passwords.txt');

            $adapter->setBasicResolver($res);
            $adapter->setRequest($cont->getRequest());
            $adapter->setResponse($cont->getResponse());
            
            $this->adapter = $adapter;
        }
        
        return $this->adapter;
    }
    
    public function detach(EventCollection $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
    
    
}