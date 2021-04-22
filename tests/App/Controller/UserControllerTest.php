<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $client->request('GET', 'users');
        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(302, $statusCode);
    }

    public function testEdit()
    {
        $client = static::createClient();

        $client->request('GET', 'users/1/edit');
        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(302, $statusCode);
    }
}
