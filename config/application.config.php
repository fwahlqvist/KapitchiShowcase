<?php
return array(
    'modules' => array(
        'Application',
        'KapitchiBase',
        'ZfcBase',
        'ZfcAcl',
        'KapitchiIdentity',
        'KapitchiLocation',
        'KapitchiContact',
        'KapitchiContactIdentity',
        'KapitchiFileManager',
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
