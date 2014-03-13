<?php

namespace Zoop\Common\Database\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zoop\Juggernaut\Helper\Database\Mysqli;
use Zoop\Juggernaut\Adapter\FileSystem;

class DatabaseManagerFactory implements FactoryInterface
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

        $cache = new FileSystem($config['cache']['directory']);

        $db = new Mysqli($cache);
        $db->connect(
            $dbConfig['host'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['database'],
            $dbConfig['port']
        );

        if ($config['dev'] === true) {
            $db->setLogQueries(true)->setDisplayErrors(true);
        }

        return $db;
    }
}
