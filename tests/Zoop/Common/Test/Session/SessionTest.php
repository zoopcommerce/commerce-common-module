<?php

namespace Zoop\Common\Test\Session;

use Zoop\Common\Test\BaseTest;
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

        $this->assertInstanceOf('Zend\Session\SaveHandler\SaveHandlerInterface', $handler);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSessionManager()
    {
        $session = $this->getApplicationServiceLocator()->get('zoop.commerce.common.session');

        $this->assertInstanceOf('Zend\Session\ManagerInterface', $session);
        $this->assertTrue($session->sessionExists());
    }
}
