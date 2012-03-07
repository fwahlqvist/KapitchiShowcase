<?php

namespace KapitchiContact\Form;

use Zend\Form\Form;

class Contact extends Form {
    
    public function init() {
        $this->addElement('hidden', 'id');
        
        //name
        $nameSubForm = new Form();
        //$nameSubForm->addElement('text', 'formatted');
        $nameSubForm->addElement('text', 'givenName');
        $nameSubForm->addElement('text', 'middleName');
        $nameSubForm->addElement('text', 'familyName');
        $nameSubForm->addElement('text', 'honorificPrefix');
        $nameSubForm->addElement('text', 'honorificSuffix');
        
        $this->addSubForm($nameSubForm, 'name');
        
        //phoneNumbers
        $phoneNumberSubForm = new Form();
        foreach(array('mobile', 'work', 'home') as $type) {
            $phoneNumberTypeForm = new Form();
            $phoneNumberTypeForm->addElement('select', 'type');
            $phoneNumberTypeForm->addElement('checkbox', 'primary');
            $phoneNumberTypeForm->addElement('text', 'value');
            
            $phoneNumberSubForm->addSubForm($phoneNumberTypeForm, $type);
        }
        $this->addSubForm($phoneNumberSubForm, 'phoneNumbers');
        
        //emails
        $emailsSubForm = new Form();
        foreach(array('personal', 'work') as $type) {
            $typeForm = new Form();
            $typeForm->addElement('select', 'type');
            $typeForm->addElement('checkbox', 'primary');
            $typeForm->addElement('text', 'value');
            
            $emailsSubForm->addSubForm($typeForm, $type);
        }
        $this->addSubForm($emailsSubForm, 'emails');
        
        
    }
}