<?php

namespace Zoop\Common\Session\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\ManagerInterface;
use Zend\Session\SessionManager;
use Zend\Session\SaveHandler\SaveHandlerInterface;

class SessionManagerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ManagerInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['zoop']['session'];

        $handler = $serviceLocator->get('zoop.commerce.common.session.handler.' . $config['handler']);

        if ($handler instanceof SaveHandlerInterface) {
            $manager = new SessionManager();
            $manager->setSaveHandler($handler);

//            Container::setDefaultManager($manager);
            $queryStringSession = filter_input(INPUT_GET, 's');

            if (!empty($queryStringSession)) {
                $manager->setId($queryStringSession);
            }
            $manager->start();

            return $manager;
        }
    }

}
