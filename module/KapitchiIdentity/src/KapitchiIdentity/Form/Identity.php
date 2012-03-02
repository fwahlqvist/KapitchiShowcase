<?php

namespace KapitchiIdentity\Form;

use Zend\Form\Form;

class Identity extends Form {
    public function init() {
        $this->addElement('hidden', 'id');
        $this->addElement('text', 'created');
    }
}