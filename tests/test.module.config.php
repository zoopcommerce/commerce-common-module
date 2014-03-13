<?php

return [
    'doctrine' => [
        'odm' => [
            'connection' => [
                'commerce' => [
                    'dbname' => 'zoop_test',
                    'server' => 'localhost',
                    'port' => '27017',
                    'user' => '',
                    'password' => '',
                ],
            ],
            'configuration' => [
                'commerce' => [
                    'metadata_cache' => 'doctrine.cache.array',
                    'default_db' => 'zoop_test',
                ]
            ],
        ],
    ],
    'zoop' => [
        'aws' => [
            'key' => 'AKIAJE2QFIBMYF5V5MUQ',
            'secret' => '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',
            's3' => [
                'buckets' => [
                    'test' => 'zoop-web-assets-test',
                ],
                'endpoint' => [
                    'test' => 'https://zoop-web-assets-dev.s3.amazonaws.com',
                ],
            ],
        ],
        'db' => [
            'host' => 'localhost',
            'database' => 'zoop_development',
            'username' => 'root',
            'password' => 'reverse',
            'port' => 3306,
        ],
        'cache' => [
            'handler' => 'mongodb',
            'mongodb' => [
                'host' => 'localhost',
                'database' => 'zoop_test',
                'collection' => 'Cache',
                'username' => '',
                'password' => '',
                'port' => 27017,
            ],
        ],
        'sendgrid' => [
            'username' => '',
            'password' => ''
        ],
        'session' => [
            'handler' => 'mongodb',
            'mongodb' => [
                'host' => 'localhost',
                'database' => 'zoop_test',
                'collection' => 'Session',
                'username' => '',
                'password' => '',
                'port' => 27017,
            ]
        ],
    ],
    'service_manager' => [
        'factories' => [
            //services
            'zoop.commerce.common.email.sendgrid' => 'Zoop\Common\Email\Service\SendGridFactory',
            'zoop.commerce.common.file.image.upload' => 'Zoop\Common\File\Service\ImageUploadFactory',
            'zoop.commerce.common.file.upload' => 'Zoop\Common\File\Service\UploadFactory',
            'zoop.commerce.common.file.image' => 'Zoop\Common\File\Service\ImageFactory',
            'zoop.commerce.common.database.entitymanager' => 'Zoop\Common\Database\Service\EntityManagerFactory',
            'zoop.commerce.common.database.database' => 'Zoop\Common\Database\Service\DatabaseManagerFactory',
            'zoop.commerce.common.database.session' => 'Zoop\Common\Database\Service\SessionManagerFactory',
        ],
    ],
];
