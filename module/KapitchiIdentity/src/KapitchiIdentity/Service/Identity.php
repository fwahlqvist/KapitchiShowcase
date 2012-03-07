<?php

namespace KapitchiIdentity\Service;

use Zend\Form\Form,
        KapitchiBase\Service\ServiceAbstract;

class Identity extends ServiceAbstract {
    protected $mapper;
    
    public function persist(array $params) {
        if(empty($params['data'])) {
            throw new \InvalidArgumentException("params[data] needs to be array");
        }
        
        $params = array(
            'params' => $params,
        );
        
        $mapper = $this->getMapper();
        $mapper->beginTransaction();
        
        $eventRet = $this->events()->trigger('persist.pre', $this, $params);
        foreach($eventRet as $event) {
            $params = array_merge_recursive($params, $event);
        }
        
        $this->createModelFromArray($params['data']);
        $ret = $mapper->persist($model);
        var_dump($ret);
        exit;

        $eventRet = $this->events()->trigger('persist.post', $this, $params);
        foreach($eventRet as $event) {
            $params = array_merge_recursive($params, $event);
        }
        
        $mapper->commit();
        
        return $params;
    }
    
    public function update(array $params) {
        //TODO
        throw new \Exception("N/I");
    }
    
    public function delete(array $params) {
        //TODO
        throw new \Exception("N/I");
    }
    
    public function setMapper($mapper) {
        $this->mapper = $mapper;
    }
    
    public function getMapper() {
        return $this->mapper;
    }
    
    protected function createModelFromArray(array $data) {
        //TODO matusz: use locator for this
        $model = \KapitchiIdentity\Model\Identity::fromArray($data);
        return $model;
    }
}