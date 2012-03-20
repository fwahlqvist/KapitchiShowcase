<?php
return array(
    'modules' => array(
        'Application',
        'KapitchiBase',
        'KapitchiAcl',
        'KapitchiIdentity',
        'KapitchiLocation',
        'KapitchiContact',
        'KapitchiContactIdentity',
        'Test',
    ),
    'module_listener_options' => array( 
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
