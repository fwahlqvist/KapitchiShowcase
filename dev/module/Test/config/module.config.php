<?php
return array(
    'di' => array(
        'instance' => array(
            //ROUTER
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'Test' => array(
                            'type' => 'Segment',
                            'options' => array(
                                'route' => '/test[/:action]',
                                'defaults' => array(
                                    'controller' => 'Test\Controller\TestController',
                                    'action'     => 'index',
                                ),
                            ),
                            'may_terminate' => true,
                        ),
                    ),
                ),
            ),
            
            
        ),
    ),
);
