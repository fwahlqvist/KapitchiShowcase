<?php
return array(
    'di' => array(
        'definition' => array(
            'class' => array(
            ),
        ),
        'instance' => array(
            'KapitchiContact\Plugin\KapitchiIdentity' => array(
                'parameters' => array(
                    'locator' => 'Zend\Di\Di',
                )
            ),
            'KapitchiContact\Service\Contact' => array(
                'parameters' => array(
                )
            ),
        ),
    ),
);
