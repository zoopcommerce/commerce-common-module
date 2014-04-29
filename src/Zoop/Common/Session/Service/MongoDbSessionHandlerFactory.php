<?php

namespace Zoop\Common\Session\Service;

use \MongoClient;
use Zend\Session\SaveHandler\MongoDB;
use Zend\Session\SaveHandler\MongoDBOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MongoDbSessionHandlerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return MongoDB
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sessionConfig = $serviceLocator->get('config')['zoop']['session'];
        $mongoConfig = $sessionConfig['mongodb'];

        $mongo = new MongoClient($mongoConfig['connectionString']);

        if (!empty($mongoConfig['options'])) {
            $options = new MongoDBOptions($mongoConfig['options']);
            $saveHandler = new MongoDB($mongo, $options);
        } else {
            $saveHandler = new MongoDB($mongo);
        }

        return $saveHandler;
    }
}
