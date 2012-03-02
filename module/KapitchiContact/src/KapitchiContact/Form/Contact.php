<?php

namespace KapitchiContact\Form;

use Zend\Form\Form;

class Contact extends Form {
    public function init() {
        $this->addElement('hidden', 'id');
        $this->addElement('text', 'firstname');
        $this->addElement('text', 'surname');
        $this->addElement('text', 'email');
    }
}