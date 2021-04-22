<?php

namespace Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');
        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(302, $statusCode);
    }

    public function testCreate()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/create');
        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(302, $statusCode);
    }

    public function testEdit()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/20/edit');
        $statusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(302, $statusCode);
    }
}
