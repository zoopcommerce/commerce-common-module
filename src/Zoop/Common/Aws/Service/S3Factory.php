<?php

namespace Zoop\Common\Aws\Service;

use Zoop\Common\Aws\S3\S3;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class S3Factory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return S3
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config')['zoop']['aws'];

        return new S3($config['key'], $config['secret'], $config['s3']['buckets']['web']);
    }
}
