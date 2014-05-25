<?php

$mongoConnectionString = 'mongodb://localhost:27017';
$mongoZoopDatabase = 'zoop_development';
$mysqlZoopDatabase = 'zoop_development';

return [
    'doctrine' => [
        'eventmanager' => [
            'commerce' => [],
        ],
        'odm' => [
            'connection' => [
                'commerce' => [
                    'dbname' => $mongoZoopDatabase,
                    'connectionString' => $mongoConnectionString,
                ],
            ],
            'configuration' => [
                'commerce' => [
                    'class_metadata_factory_name' => 'Zoop\Shard\ODMCore\ClassMetadataFactory',
                    'metadata_cache' => 'doctrine.cache.juggernaut.filesystem',
                    'generate_proxies' => false,
                    'proxy_dir' => __DIR__ . '/../data/proxies',
                    'proxy_namespace' => 'proxies',
                    'generate_hydrators' => false,
                    'hydrator_dir' => __DIR__ . '/../data/hydrators',
                    'hydrator_namespace' => 'hydrators',
                    'default_db' => $mongoZoopDatabase,
                    'driver' => 'doctrine.driver.default',
                ]
            ],
            'documentmanager' => [
                'commerce' => [
                    'connection' => 'doctrine.odm.connection.commerce',
                    'configuration' => 'doctrine.odm.configuration.commerce',
                    'eventmanager' => 'doctrine.eventmanager.commerce'
                ]
            ],
        ],
        //need to fix up ORM
        'orm' => [
            'generate_proxies' => false,
            'proxy_dir' => __DIR__ . '/../../data/proxies',
            'proxy_namespace' => 'proxies',
            'generate_hydrators' => false,
            'hydrator_dir' => __DIR__ . '/../../data/hydrators',
            'hydrator_namespace' => 'hydrators',
            'paths' => [
                'Zoop\Legacy\Entity' => __DIR__ . '/../module/src/Zoop/Legacy/Entity',
            ],
        ],
    ],
    'zoop' => [
        'aws' => [
            'key' => '%%%AWS_KEY%%%',
            'secret' => '%%%AWS_SECRET_KEY%%%',
            's3' => [
                'buckets' => [
                    'web' => 'zoop-web-assets',
                    'ops' => 'zoop-ops-sydney'
                ],
                'endpoint' => [
                    'web' => 'https://zoop-web-assets.s3.amazonaws.com',
                    'ops' => 'https://zoop-ops-sydney.s3.amazonaws.com',
                ],
            ],
            'cloudfront' => [
                'endpoint' => [
                    'web' => 'https://dvmsykbq2wgf8.cloudfront.net',
                    'ops' => '',
                ],
            ]
        ],
        'db' => [
            'host' => 'localhost',
            'database' => $mysqlZoopDatabase,
            'username' => 'zoop',
            'password' => 'yourtown1',
            'port' => 3306,
        ],
        'cache' => [
            'directory' => __DIR__ . '/../../data/cache/',
            'handler' => 'mongodb',
            'mongodb' => [
                'connectionString' => $mongoConnectionString,
                'options' => [
                    'database' => $mongoZoopDatabase,
                    'collection' => 'Cache',
                ]
            ],
            'sql' => 300, //ttl in seconds
            'ttl' => 300, //ttl in seconds
            'page' => 300, //ttl in seconds
        ],
        'file_upload' => [
            'temp_dir' => __DIR__ . '/../../data/temp',
            's3_temp_dir' => 'temp',
        ],
        'email' => [
            'dev' => [
                'name' => 'Josh',
                'address' => 'josh.stuart@zoopcommerce.com'
            ],
            'support' => [
                'name' => 'Zoop Support',
                'address' => 'support@zoopcommerce.com'
            ],
            'sales' => [
                'address' => 'sales@zoopcommerce.com',
                'name' => 'Zoop'
            ],
            'info' => [
                'name' => 'Zoop',
                'address' => 'info@zoopcommerce.com'
            ],
            'no_reply' => [
                'name' => 'Zoop',
                'address' => 'no-reply@zoopcommerce.com'
            ]
        ],
        'juggernaut' => [
            'file_system' => [
                'directory' => 'data/cache/doctrine'
            ]
        ],
        'shard' => [
            'manifest' => [
                'commerce' => [
                    'model_manager' => 'doctrine.odm.documentmanager.commerce',
                    'extension_configs' => [
                        'extension.odmcore' => true,
                        'extension.softDelete' => true,
                        'extension.accesscontrol' => true,
                        'extension.crypt' => true,
                        'extension.serializer' => true,
                        'extension.validator' => true,
                        'extension.stamp' => true,
                        'extension.state' => true,
                        'extension.zone' => true
                    ],
                    'models' => [
                        'Zoop\Common\DataModel' => __DIR__ . '/../src/Zoop/Common/DataModel',
                        'Zoop\Common\File\DataModel' => __DIR__ . '/../src/Zoop/Common/File/DataModel'
                    ],
                    'service_manager_config' => [
                        'factories' => [
                            'modelmanager' => 'Zoop\Common\Database\Service\CommerceDocumentManagerFactory',
                            'eventmanager' => 'Zoop\ShardModule\Service\EventManagerFactory'
                        ]
                    ]
                ],
            ],
        ],
        'sendgrid' => [
            'username' => '%%%SENDGRID_USERNAME%%%',
            'password' => '%%%SENDGRID_PASSWORD%%%'
        ],
        'session' => [
            'ttl' => (60 * 60 * 3), //3 hours
            'handler' => 'mongodb',
            'mongodb' => [
                'connectionString' => $mongoConnectionString,
                'options' => [
                    'database' => $mongoZoopDatabase,
                    'collection' => 'Session',
                    'saveOptions' => [
                        'w' => 1
                    ]
                ]
            ]
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zoop\Common\Session\Service\AbstractContainerFactory' //zoop.commerce.common.session.container.{container_name}
        ],
        'factories' => [
            //services
            'zoop.commerce.common.aws.s3' => 'Zoop\Common\Aws\Service\S3Factory',
            'zoop.commerce.common.email.sendgrid' => 'Zoop\Common\Email\Service\SendGridFactory',
            'zoop.commerce.common.file.image.upload' => 'Zoop\Common\File\Service\ImageUploadFactory',
            'zoop.commerce.common.file.upload' => 'Zoop\Common\File\Service\UploadFactory',
            'zoop.commerce.common.file.image' => 'Zoop\Common\File\Service\ImageFactory',
            'zoop.commerce.common.database.entitymanager' => 'Zoop\Common\Database\Service\EntityManagerFactory',
            'zoop.commerce.common.database.database' => 'Zoop\Common\Database\Service\DatabaseManagerFactory',
            'zoop.commerce.common.session' => 'Zoop\Common\Session\Service\SessionManagerFactory',
            'zoop.commerce.common.session.handler.mongodb' => 'Zoop\Common\Session\Service\MongoDbSessionHandlerFactory',
        ],
    ],
];
