<?php
return array(
    'ZfcAcl' => array(
        'options' => array(
            'enable_cache' => false,//enable static acl session cache 
            'enable_guards' => array(
                'route' => true,//enable route guard
                'event' => true,//enable event guard
            ),
            'enable_loaders' => array(
                'resource' => true,
            )
        ),
    ),
    'di' => array(
        'instance' => array(
            'ZfcAcl\Model\Mapper\AclLoaderConfig' => array(
                'parameters' => array(
                    'config' => array(
                        'resources' => array(
                            'Route/Default' => null,//used by ZfcAcl\Guard\Route
                        ),
                        'rules' => array(
                            'allow' => array(
                                'allow/default_route' => array(array('auth', 'guest'), 'Route/Default'),
                            )
                        )
                    ),
                ),
            ),
            'ZfcAcl\Model\Mapper\RouteResourceMapConfig' => array(
                'parameters' => array(
                    'config' => array(
                        'default' => 'Route/Default',
                        'child_map' => array(
                            'default' => array(
                                'default' => 'Route/Default',
                            )
                        )
                    )
                )
            ),
        )
    ),
);
