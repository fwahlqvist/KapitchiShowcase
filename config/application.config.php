<?php
return array(
    'modules' => array(
        'ZfcBase',
        'Application',
        'KapitchiBase',
        'KapitchiIdentity',
        'KapitchiContact',
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
