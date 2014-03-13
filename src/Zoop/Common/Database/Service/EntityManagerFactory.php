<?php

namespace Zoop\Common\Database\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver as OrmAnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class EntityManagerFactory implements FactoryInterface
{
    /**
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return EntityManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['zoop'];
        $dbConfig = $config['db'];

        //setup entity manager
        $isDevMode = false;

        // the connection configuration
        $dbParams = [
            'driver' => 'pdo_mysql',
            'host' => $dbConfig['host'],
            'user' => $dbConfig['username'],
            'password' => $dbConfig['password'],
            'dbname' => $dbConfig['database'],
            'port' => $dbConfig['port'],
        ];

        $doctrinConfig = $serviceLocator->get('config')['doctrine'];
        $ormConfig = Setup::createConfiguration($isDevMode);
        $driver = new OrmAnnotationDriver(new AnnotationReader(), $doctrinConfig['orm']['paths']);

        AnnotationRegistry::registerLoader('class_exists');

        $ormConfig->setMetadataDriverImpl($driver);

        $ormConfig->setProxyDir($doctrinConfig['orm']['proxy_dir']);
        $ormConfig->setProxyNamespace($doctrinConfig['orm']['proxy_namespace']);
        $ormConfig->setAutoGenerateProxyClasses($doctrinConfig['orm']['proxy_dir']);

        return EntityManager::create($dbParams, $ormConfig);
    }
}
