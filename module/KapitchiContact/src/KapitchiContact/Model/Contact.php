<?php

namespace KapitchiContact\Model;

use KapitchiBase\Stdlib\PluralField;

/**
 * Let's try to be as much compatible with OpenSocial as possible.
 * http://opensocial-resources.googlecode.com/svn/spec/2.0.1/Social-Data.xml#Person
 */
class Contact extends \ZfcBase\Model\ModelAbstract {
    private $id;
    
    private $name;
    private $displayName;
    
    //PluralField<string>
    private $phoneNumbers;
    
    //PluralField<string>
    private $emails;
    
    //PluralField<Address>
    private $addresses;
    
    public function __construct() {
        $this->name = new Name();
        $this->phoneNumbers = new PluralField();
        $this->emails = new PluralField();
        $this->addresses = new PluralField();
    }
    
    public function setPhoneNumbers(array $phoneNumbers) {
        $this->phoneNumbers = PluralField::fromArray($phoneNumbers);
    }
    
    public function setEmails(array $emails) {
        $this->emails = PluralField::fromArray($emails);
    }
    
    public function setAddresses(array $addresses) {
        $this->addresses = PluralField::fromArray($addresses);
    }
    
    public function setName(array $name) {
        $this->name = Name::fromArray($name);
    }
    
    public function getDisplayName() {
        if($this->name) {
            
        }
    }
}