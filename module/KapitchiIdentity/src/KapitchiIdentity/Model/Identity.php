<?php

namespace KapitchiIdentity\Model;

class Identity extends \ZfcBase\Model\ModelAbstract {
    private $id;
    private $created;
    private $ownerId;
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getOwnerId() {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId) {
        $this->ownerId = $ownerId;
    }


}