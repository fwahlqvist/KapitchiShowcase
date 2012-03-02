<?php

namespace KapitchiIdentity\Service;

use Zend\Form\Form,
        KapitchiBase\Rest\RestfulServiceAbstract;

class Identity extends RestfulServiceAbstract {
    protected $mapper;
    
    public function getList(array $filter) {
        //TODO
        throw new Exception("N/I");
    }
    
    public function get($id) {
        //TODO
        throw new Exception("N/I");
    }
    
    public function persist(array $params) {
        if(empty($params['data'])) {
            throw new \InvalidArgumentException("params[data] needs to be array");
        }
        $data = $params['data'];
        if(!empty($data['id'])) {
            $ret = $this->update($data['id'], $data);
        } else {
            $ret = $this->create($data);
        }
        
        return $ret;
    }
    
    public function create(array $data) {
        $model = $this->createModelFromArray($data);
        $params = array(
            'data' => $data,
            'identity' => $model,
        );
        $mapper = $this->getMapper();
        $mapper->beginTransaction();
        $this->events()->trigger('create.pre', $this, $params);
        
        $ret = $mapper->persist($model);

        $this->events()->trigger('create.post', $this, $params);
        $mapper->commit();
        
        return $ret;
    }
    
    public function update($id, array $data) {
        //TODO
        throw new \Exception("N/I");
    }
    
    public function delete($id) {
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