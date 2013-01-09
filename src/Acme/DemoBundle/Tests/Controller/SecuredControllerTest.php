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
        $session = $client->getContainer()->get('session');
        $client->getCookieJar()->set(new \Symfony\Component\BrowserKit\Cookie($session->getName(), $session->getId()));

        # fake request
        $client->request('GET', '/');

        $token = new UsernamePasswordToken( 'admin', 'adminpass', 'secured_area', array() );
        $session->set('_security_secured_area', serialize($token));
        $session->save();

        $crawler = $client->request('GET', '/demo/secured/hello/admin/Alexey');

        $this->assertEquals(
            $client->getResponse()->getStatusCode(),
            200
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("logged in as admin")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('h1:contains("Hello Alexey secured for Admins only!")')->count()
        );

    }
}
