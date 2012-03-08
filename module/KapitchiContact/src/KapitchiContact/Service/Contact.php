<?php

namespace KapitchiContact\Service;

use KapitchiContact\Model\Mapper\Contact as ContactMapper,
    KapitchiBase\Service\ServiceAbstract;

class Contact extends ServiceAbstract {
    /**
     * @var KapitchiContact\Model\Mapper\Contact 
     */
    protected $mapper;
    
    public function persist(array $data) {
        $params = $this->triggerParamsMergeEvent('persist.pre', array('data' => $data));
        
        $model = $this->createModelFromArray($data);
        $mapper = $this->getMapper();
        
        $ret = $this->getMapper()->persist($model);
        $params['contact'] = $model;
        
        $params = $this->triggerParamsMergeEvent('persist.post', $params);
        
        return $params;
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