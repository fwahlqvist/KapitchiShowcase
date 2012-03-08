<?php

namespace KapitchiIdentity\Controller;

use Zend\Authentication\Adapter as AuthAdapter,
        Exception as AuthException,
        Zend\View\Model\ViewModel as ViewModel;

class AuthController extends \Zend\Mvc\Controller\ActionController {
    public function indexAction() {
        $aclService = $this->getLocator()->get('KapitchiIdentity\Service\Acl');
        $aclService->invalidate();
        $ret = $aclService->isAllowed('kapitchiidentity.auth.indexAction');
        var_dump($ret);
        exit;
        /*$ret = $this->getLocator()->get('KapitchiIdentity\Service\Identity');
        $x = $ret->persist(array(
            'id' => 3,
            'created' => '2012-12-12 10:00:00',
            'ownerId' => 1,
        ));
        */

    }
    
    public function loginAction() {
        $form = $this->getLocator()->get('KapitchiIdentity\Form\Identity');
        
        if($this->getRequest()->isPost()) {
            var_dump($this->getRequest()->post());
            exit;
            if($form->isValid($this->getRequest()->post()->toArray())) {
                $service  = $this->getLocator()->get('KapitchiIdentity\Service\Identity');
                $ret = $service->persist($form->getValues());
                var_dump('POSTED');
                var_dump($ret);
                exit;
            }
        }
        
        $viewModel = $this->getLocator()->get('KapitchiIdentity\View\Model\AuthLogin');
        $viewModel->setVariable('form', $form);
        
        $subModel = new ViewModel();
        $subModel->setTemplate('test');
        
        $viewModel->addChild($subModel, 'submodel');
        
        return $viewModel;
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

        /*
         * array(
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
            )
         */
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