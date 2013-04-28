<?php

namespace Acme\DemoBundle\Tests\FOSUser;

use Acme\DemoBundle\Service\UserManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * phpunit -c app/ src/Acme/DemoBundle/Tests/FOSUser/FOSUserMultiConnection.php
 */
class FOSUserMultiConnection extends WebTestCase
{
    public function test1()
    {
        $client = static::createClient();

        /** @var $user_manager_conn1 UserManager */
        $user_manager_conn1 = $client->getContainer()->get('acme.user_manager.conn1');

        /** @var $user_manager_conn2 UserManager */
        $user_manager_conn2 = $client->getContainer()->get('acme.user_manager.conn2');

        /** @var $om1 EntityManager */
        $om1 = $user_manager_conn1->getOM();
        /** @var $om2 EntityManager */
        $om2 = $user_manager_conn2->getOM();

        $this->assertNotEquals($om1->getConnection()->getDatabase(), $om2->getConnection()->getDatabase());
    }
}
