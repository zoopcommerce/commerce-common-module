<?php

namespace Zoop\Common\User\Service;

use Zoop\Common\User\DataModel\Guest;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GuestFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \Zend\Authentication\AuthenticationService
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $return = new Guest;
        $return->setUsername('Guest');
        $return->setRoles(['guest']);

        return $return;
    }
}
