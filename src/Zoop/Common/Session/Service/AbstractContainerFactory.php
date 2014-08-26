<?php

namespace Zoop\Common\Session\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;

class AbstractContainerFactory implements AbstractFactoryInterface
{
    protected $containers = [];

    const CONTAINER_PREFIX = 'zoop.commerce.common.session.container';

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return boolean
     * 
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return (strpos($name, self::CONTAINER_PREFIX) === 0);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return Container
     * 
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $containerName = str_replace(self::CONTAINER_PREFIX . '.', '', $name);
        
        if (isset($this->containers[$containerName])) {
            return $this->containers[$containerName];
        }

        $session = $serviceLocator->get('zoop.commerce.common.session');

        $container = new Container($containerName);
        $container->setDefaultManager($session);

        $this->containers[$containerName] = $container;
        return $container;
    }
}
