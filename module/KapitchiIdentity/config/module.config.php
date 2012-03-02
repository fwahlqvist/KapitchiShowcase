<?php
return array(
    'kapitchiidentity' => array(
        'auth_adapters' => array('kapitchi-http_auth_adapter'),
    ),
    //XXX ACL is used 
    'acl' => array(
        
    ),
    'di' => array(
        'definition' => array(
            'class' => array(
                //'KapitchiIdentity\Service\IdentityForm' => array('supertypes' => array('KapitchiIdentity\Service\Identity')),
            ),
        ),
        'instance' => array(
            'alias' => array(
                'kapitchiidentity-auth_controller'                          => 'KapitchiIdentity\Controller\AuthController',
                //'kapitchiidentity-user_service'             => 'ZfcUser\Service\User',
                'kapitchiidentity-auth_service'             => 'Zend\Authentication\AuthenticationService',
                'kapitchiidentity-identity_service'             => 'KapitchiIdentity\Service\Identity',
                'kapitchiidentity-http_auth_adapter'             => 'Zend\Authentication\Adapter\Http',
                
                //XXX
                'kapitchiidentity-zenddb_writer'        => 'Zend\Db\Adapter\AbstractAdapter',
                'kapitchiidentity-zenddb_reader'         => 'kapitchiidentity-zenddb_writer',
            ),
            'KapitchiIdentity\Form\Identity' => array(
                
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options'  => array(
                        'script_paths' => array(
                            'kapitchiidentity' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),
            'Zend\Authentication\Adapter\Http' => array(
                'parameters' => array(
                    'config' => array(
                        'accept_schemes' => 'basic',
                        'realm' => 'My Site!',
                     ),
                ),
            ),
            'KapitchiIdentity\Service\Identity' => array(
                'parameters' => array(
                    'locator' => 'Zend\Di\Di',
                    'mapper' => 'KapitchiIdentity\Model\Mapper\IdentityTest',
                ),
            ),
            
            
            //XXX
            'zfcuser_write_db' => array(
                'parameters' => array(
                    'pdo'    => 'zfcuser_pdo',
                    'config' => array(),
                ),
            ),
            'ZfcUser\Model\Mapper\UserZendDb' => array(
                'parameters' => array(
                    'readAdapter'  => 'kapitchiidentity-zenddb_reader',
                    'writeAdapter' => 'kapitchiidentity-zenddb_writer',
                ),
            ),
            
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'kapitchiidentity' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/identity',
                                'defaults' => array(
                                    'controller' => 'kapitchiidentity-auth_controller',
                                    'action'     => 'index',
                                ),
                            ),
                            'may_terminate' => true,
                            'child_routes' => array(
                                'login' => array(
                                    'type' => 'Literal',
                                    'options' => array(
                                        'route' => '/login',
                                        'defaults' => array(
                                            'controller' => 'kapitchiidentity-auth_controller',
                                            'action'     => 'login',
                                        ),
                                    ),
                                ),
                                'authenticate' => array(
                                    'type' => 'Literal',
                                    'options' => array(
                                        'route' => '/authenticate',
                                        'defaults' => array(
                                            'controller' => 'kapitchiidentity-auth_controller',
                                            'action'     => 'authenticate',
                                        ),
                                    ),
                                ),
                                'logout' => array(
                                    'type' => 'Literal',
                                    'options' => array(
                                        'route' => '/logout',
                                        'defaults' => array(
                                            'controller' => 'kapitchiidentity-auth_controller',
                                            'action'     => 'logout',
                                        ),
                                    ),
                                ),
                                'register' => array(
                                    'type' => 'Literal',
                                    'options' => array(
                                        'route' => '/register',
                                        'defaults' => array(
                                            'controller' => 'kapitchiidentity-auth_controller',
                                            'action'     => 'register',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            
        ),
    ),
);
