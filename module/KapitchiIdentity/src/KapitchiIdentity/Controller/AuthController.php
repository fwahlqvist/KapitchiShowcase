<?php

namespace KapitchiIdentity\Controller;

use Zend\Authentication\Adapter as AuthAdapter,
        Exception as AuthException;

class AuthController extends \Zend\Mvc\Controller\ActionController {
    public function indexAction() {
//        $defs = $this->getLocator()->definitions();
//        $def = new \Zend\Di\Definition\ClassDefinition('Zend\Db\Adapter\AbstractAdapter');
//        $def->setInstantiator('Zend\Db\Db::factory');
//        $defs->addDefinition($def);
//        
//        \Zend\Di\Display\Console::export($this->getLocator());
//        exit;
        
        //$identityForm = new \Zend\Form\Form();
        //$identityForm->setIsArray(true);
        //THIS DOES THE SAME
        $form = $this->getLocator()->get('KapitchiIdentity\Form\Identity');
        //$form->setDefaults(array('created' => time(), 'id' => 1));
        
        $service  = $this->getLocator()->get('KapitchiIdentity\Service\Identity');
        $form->isValid(array(
            'id' => null,
            'created' => time(),
            'contact' => array(
                'name' => array(
                    'givenName' => 'Matus',
                    'familyName' => 'Zeman',
                    'middleName' => 'Vaclav',
                    'honorificPrefix' => 'MSc.',
                ),
                'phoneNumbers' => array('mobile' => array(
                    'type' => 'mobile',
                    'value' => '07515722300',
                    'primary' => '1',
                )),
                'emails' => array('personal' => array(
                    'type' => 'personal',
                    'value' => 'matus.zeman@gmail.com',
                    'primary' => '1',
                )),
            )
        ));
        
        $ret = $service->persist(array(
            'data' => $form->getValues()
        ));
        
        var_dump($ret);
        exit;
    }
    
    public function loginAction() {
        return array('xxx' => 'fsdfsd');
    }
    
    public function authenticateAction() {
        $authService = $this->getLocator()->get('kapitchiidentity-auth_service');
        $response = $this->getResponse();
        $params = array(
            'locator' => $this->getLocator(),
            'auth_service' => $this->getRequest(),
            'request' => $this->getRequest(),
            'response' => $response,
        );
        
        $result = $this->events()->trigger('authenticate.pre', $this, $params, function($ret) {
            return ($ret instanceof AuthAdapter || is_string($ret));//it might be DI indentifier!
        });
        $adapter = $result->last();
        while(!$adapter instanceof AuthAdapter) {
            try {
                //it might be DI indentifier!
                $adapter = $this->getLocator()->get($adapter);
            } catch(\Zend\Di\Exception\ClassNotFoundException $e) {
                throw new AuthException("I really expected some AuthAdapter here!");
            }
        }
        
        //var_dump($this->getEvent());
        //exit;
        
        return array(
            'myhome' => 'bububub'
        );

        //$this->plugin('forward')->dispatch('kapitchiidentity-auth_http_authentication');
        //$result = $authService->authenticate($adapter);
//        var_dump($result);
//        exit;
//        if(!$result->isValid()) {
//            return $response;
//            var_dump($response);
//            exit;
//            if($response->isRedirect()) {
//                return $response;
//            }
//        }
        
//        var_dump(\Zend\Stdlib\IteratorToArray::convert($ret, true));
        //exit;
    }
}