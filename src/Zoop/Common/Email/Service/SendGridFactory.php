<?php

namespace Zoop\Common\Email\Service;

use Zoop\Common\Email\SendGrid\Email;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SendGridFactory implements FactoryInterface
{
    /**
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Email
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['zoop']['sendgrid'];

        $email = new Email($config['username'], $config['password']);

        return $email;
    }
}
