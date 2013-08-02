<?php

namespace Acme\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BugTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient(array(
            'environment' => 'test',
            'debug' => true,
        ));

        $client->request('GET', '/jms_secure');
    }

    public function test2Index()
    {
        $client = static::createClient(array(
            'environment' => 'test_new',
            'debug' => true,
        ));

        $client->request('GET', '/jms_secure');
    }
}
