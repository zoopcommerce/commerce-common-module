<?php

/**
 * @package Zoop
 */

namespace Zoop\Common;

use Zend\Mvc\MvcEvent;

/**
 *
 * @author  Josh Stuart <josh.stuart@zoopcommerce.com>
 */
class Module
{
    /**
     * @param \Zend\EventManager\Event $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getTarget();
        $serviceManager = $application->getServiceManager();
        $eventManager = $application->getEventManager();

        $eventManager->attach($serviceManager->get('zoop.commerce.common.filterlistener.softdeleted'));
    }

    /**
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../../config/module.config.php';
    }
}
