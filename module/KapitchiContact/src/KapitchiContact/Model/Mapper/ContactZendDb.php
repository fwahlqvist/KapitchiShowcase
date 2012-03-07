<?php

namespace KapitchiContact\Model\Mapper;

use KapitchiContact\Model\Mapper\Contact as ContactMapper,
        KapitchiContact\Model\Contact as ContactModel;

class ContactZendDb implements ContactMapper {
    public function persist(ContactModel $contact) {
        
        return true;
    }
    
    public function remove(ContactModel $contact) {
        
    }
}