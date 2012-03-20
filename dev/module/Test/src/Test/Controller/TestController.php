<?php
namespace Test\Controller;

use Zend\Mvc\Controller\ActionController;

class TestController extends ActionController {
    
    public function indexAction() {
        echo 'Test';
        exit;
    }
}