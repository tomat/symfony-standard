<?php

namespace Acme\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * phpunit -c app/ src/Acme/DemoBundle/Tests/Controller/SecuredControllerTest.php
 */
class SecuredControllerTest extends WebTestCase
{
    public function testAuthorizeWithSession()
    {
        $client = static::createClient();
        $client->followRedirects(false);

        $token = new UsernamePasswordToken('admin', 'adminpass', 'secured_area', array("ROLE_ADMIN"));
        $session = $client->getContainer()->get('session');
        $session->set('_security_secured_area', serialize($token));
        //$client->getCookieJar()->set(new \Symfony\Component\BrowserKit\Cookie(session_name(), true));

        $client->request('GET', '/demo/secured/hello/Alexey');

        $this->assertEquals(
            $client->getResponse()->getStatusCode(),
            200
        );
    }
}
