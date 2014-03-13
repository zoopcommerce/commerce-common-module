<?php

namespace Zoop\Common\Email\Service;

use Zoop\Common\Email\Ses\Email;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SesFactory implements FactoryInterface
{
    /**
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Email
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['zoop']['aws']['ses'];

        return new Email($config['username'], $config['password'], $config['host'], $config['post']);
    }
}
