<?php

namespace KapitchiIdentity\Controller;

use Zend\Authentication\Adapter as AuthAdapter,
        Exception as AuthException,
        Zend\Stdlib\ResponseDescription as Response,
        Zend\View\Model\ViewModel as ViewModel;

class AuthController extends \Zend\Mvc\Controller\ActionController {
    public function indexAction() {
        $authService = $this->getLocator()->get('KapitchiIdentity\Service\Auth');

        //var_dump($authService->getIdentity());
        //exit;
        
        $aclService = $this->getLocator()->get('KapitchiIdentity\Service\Acl');
        $aclService->invalidateCache();
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
    
    public function logoutAction() {
        $authService = $this->getLocator()->get('KapitchiIdentity\Service\Auth');
        $authService->clearIdentity();
        
        $this->redirect()->toRoute('kapitchiidentity');
    }
    
    public function loginAction() {
        //test
        //$this->events()->attach($this->getLocator()->get('KapitchiIdentity\Service\Auth\Http'));
        $this->events()->attach($this->getLocator()->get('KapitchiIdentity\Service\Auth\Test'));
        //END
        
        $response = $this->getResponse();
        $request = $this->getRequest();
        
        $form = $this->getLocator()->get('KapitchiIdentity\Form\Login');
        $viewModel = $this->getLocator()->get('KapitchiIdentity\View\Model\AuthLogin');
        $viewModel->setVariable('form', $form);
        
        $params = array(
            'request' => $request,
            'response' => $response,
            'viewModel' => $viewModel,
        );
        
        $result = $this->events()->trigger('authenticate.init', $this, $params, function($ret) {
            return ($ret instanceof AuthAdapter || $ret instanceof Response);
        });
        $adapter = $result->last();
        if($adapter instanceof Response) {
            return $adapter;
        }
        
        //pre event returns AuthAdapter -- we are ready to authenticate!
        if($adapter instanceof AuthAdapter) {
            $authService = $this->getLocator()->get('KapitchiIdentity\Service\Auth');

            $result = $authService->authenticate($adapter);

            $params['adapter'] = $adapter;
            $params['result'] = $result;
            $result = $this->events()->trigger('authenticate.post', $this, $params, function($ret) {
                return $ret instanceof Response;
            });
            //do we need to redirect again? example: http auth!
            $response = $result->last();
            if($response instanceof Response) {
                return $response;
            }
        }

        return $viewModel;
    }
}