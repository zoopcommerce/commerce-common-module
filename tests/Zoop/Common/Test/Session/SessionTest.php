<?php

namespace Zoop\Common\Test\Session;

use Zoop\Common\Test\BaseTest;
use Zend\Session\Container;
use Zend\Session\ManagerInterface;
use Zend\Session\SaveHandler\SaveHandlerInterface;

class SessionTest extends BaseTest
{
    /**
     * @runInSeparateProcess
     */
    public function testMongoDbHandler()
    {
        $handler = $this->getApplicationServiceLocator()->get('zoop.commerce.common.session.handler.mongodb');

        /* @var $handler SaveHandlerInterface */
        $this->assertInstanceOf('Zend\Session\SaveHandler\SaveHandlerInterface', $handler);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSessionManager()
    {
        $session = $this->getApplicationServiceLocator()->get('zoop.commerce.common.session');

        /* @var $session ManagerInterface */
        $this->assertInstanceOf('Zend\Session\ManagerInterface', $session);
        $this->assertTrue($session->sessionExists());
    }

    /**
     * @runInSeparateProcess
     */
    public function testSessionContainer()
    {
        $container = $this->getApplicationServiceLocator()->get('zoop.commerce.common.session.container.test');

        $this->assertInstanceOf('Zend\Session\Container', $container);

        /* @var $container Container */
        $this->assertEquals('test', $container->getName());
    }
}
