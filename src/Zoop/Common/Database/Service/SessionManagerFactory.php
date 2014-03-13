<?php

namespace Zoop\Common\Database\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zoop\Session\Handlers\MongoDB as MongoDBSession;

class SessionManagerFactory implements FactoryInterface
{
    /**
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return MongoDBSession
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['zoop']['session']['mongodb'];

        //init session handlers
        $mongoSession = MongoDBSession::init(
            [
                'mongo' => [
                    'server' => $config['host'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                ],
                'session' => [
                    'database' => $config['database'],
                    'collection' => $config['collection'],
                ]
            ],
            false
        );

        $session = filter_input(INPUT_GET, 's');

        if (!empty($session)) {
            $mongoSession->setId($session);
            $mongoSession->start();

            $target = filter_input(INPUT_GET, 'u');

            if (empty($target)) {
                $target = '/checkout';
            }

            $qs = null;
            if (!empty($_GET)) {
                //append additional querystrings
                $qs = '?' . http_build_query($_GET);
            }

            header('Location: ' . $target . '/' . $qs);
            exit();
        } else {
            $mongoSession->start();
        }
        return $mongoSession;
    }
}
