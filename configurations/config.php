<?php
$config = [
    'Zend\Loader\StandardAutoloader' => [
        'namespaces' => [
            'lib' => APPLICATION_PATH . '/scripts/lib',
            'controllers' => APPLICATION_PATH . '/scripts/controllers',
            'modeles' => APPLICATION_PATH . '/scripts/modeles',
            'repositories' => APPLICATION_PATH . '/scripts/repositories',
            'commandes' => APPLICATION_PATH . '/scripts/commandes'
        ],
    ],
];