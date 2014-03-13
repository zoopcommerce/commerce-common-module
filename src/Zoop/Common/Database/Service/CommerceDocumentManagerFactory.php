<?php

/**
 * @package    Zoop
 * @license    MIT
 */

namespace Zoop\Common\Database\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @since   1.0
 * @version $Revision$
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class CommerceDocumentManagerFactory implements FactoryInterface
{
    /**
     *
     * @param  \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return object
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $name = $serviceLocator->get('config')['zoop']['shard']['manifest']['commerce']['model_manager'];

        return $serviceLocator->get($name);
    }
}
