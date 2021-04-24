<?php


namespace App\Tests\App;


use App\Entity\User;
use App\Tests\AbstractWebTestCase;

class UserTest extends AbstractWebTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $admin = $this->createUser(
            self::ADMIN_NAME,
            self::ADMIN_PASS,
            self::ADMIN_MAIL,
            self::ADMIN_ROLES
        );
        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }

    public function testAccessUserList()
    {
        $this->login('testministrateur', 'test');
        $crawler = $this->client->request('GET', '/users');

        $this->assertEquals('http://localhost/users', $crawler->getUri());
    }

    public function testCreateUser()
    {
        $this->login('testministrateur', 'test');
        $this->client->request('GET', '/users/create');
        $this->client->submitForm('Ajouter', [
            'user[username]' => 'testificate',
            'user[role]' => 'ROLE_USER',
            'user[password][first]' => 'test',
            'user[password][second]' => 'test',
            'user[email]' => 'testificate@test.com'
        ]);
        $crawler = $this->client->followRedirect();

        $this->assertEquals('http://localhost/tasks', $crawler->getUri());
    }

    /**
     * @var User
     */
    public function testEditUser()
    {
        $this->login('testministrateur', 'test');
        $adminUser = $this->userRepository->findOneBy(['username' => self::ADMIN_NAME]);
        $id = $adminUser->getId();
        $this->client->request('GET', '/users/'.$id.'/edit');
        $this->client->submitForm('Modifier', [
            'user[username]' => 'testificator',
            'user[role]' => 'ROLE_ADMIN',
            'user[password][first]' => 'test',
            'user[password][second]' => 'test',
            'user[email]' => 'testificator@test.com'
        ]);
        $crawler = $this->client->followRedirect();

        $this->assertEquals('http://localhost/users', $crawler->getUri());
    }
}