<?php

namespace KapitchiContact\Service;

use KapitchiContact\Model\Mapper\Contact as ContactMapper,
    KapitchiBase\Service\ServiceAbstract;

class Contact extends ServiceAbstract {
    /**
     * @var KapitchiContact\Model\Mapper\Contact 
     */
    protected $mapper;
    
    public function persist($params) {
        if(empty($params['data'])) {
            throw new \InvalidArgumentException("data needed");
        }
        
        $model = $this->createModelFromArray($params['data']);
        $mapper = $this->getMapper();
        $ret = $this->getMapper()->persist($model);
        
        $ret = array(
            'persisted' => array($model),
        );
        
        return $ret;
    }
    
    protected function createModelFromArray(array $data) {
        //TODO matusz: use locator for this
        $model = \KapitchiContact\Model\Contact::fromArray($data);
        return $model;
    }
    
    public function setMapper($mapper) {
        $this->mapper = $mapper;
    }
    
    public function getMapper() {
        return $this->mapper;
    }
}