<?php


namespace App\Tests\App;


use App\Tests\AbstractWebTestCase;

class LoginTest extends AbstractWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $user = $this->createUser(
            self::ADMIN_NAME,
            self::ADMIN_PASS,
            self::ADMIN_MAIL,
            self::ADMIN_ROLES
        );
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function testLoginAccess()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertEquals('http://localhost/login', $crawler->getUri());
    }

    public function testLogin()
    {
        $crawler = $this->login(self::ADMIN_NAME, self::ADMIN_PASS);
        $this->assertEquals('http://localhost/', $crawler->getUri());
    }
}