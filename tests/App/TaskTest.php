<?php


namespace App\Tests\App;


use App\Entity\Task;
use App\Tests\AbstractWebTestCase;

class TaskTest extends AbstractWebTestCase
{
    private $admin;
    private $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createUser(
            self::ADMIN_NAME,
            self::ADMIN_PASS,
            self::ADMIN_MAIL,
            self::ADMIN_ROLES
        );
        $this->entityManager->persist($this->admin);
        $this->task = $this->createTask("Titre test", 'Contenu test');
        $this->entityManager->persist($this->task);
        $this->entityManager->flush();
    }

    public function testAccessTaskList()
    {
        $this->login("testministrateur", "test");
        $crawler = $this->client->request('GET', '/tasks');
        $this->assertEquals('http://localhost/tasks', $crawler->getUri());
    }

    public function testCreateTask()
    {
        $this->login("testministrateur", "test");
        $this->client->request('GET', '/tasks/create');
        $this->client->submitForm('Ajouter', [
                'task[title]' => "Tâche de test",
                'task[content]' => "S'assurer que ça fonctionne"]
        );
        $crawler = $this->client->followRedirect();
        $this->assertEquals('http://localhost/tasks', $crawler->getUri());
    }

    public function testEditTask()
    {
        $this->login("testministrateur", "test");
        $task = $this->taskRepository->findOneBy(['title' => 'Titre test']);
        $id = $task->getId();
        $this->client->request('GET', '/tasks/'.$id.'/edit');
        $this->client->submitForm('Modifier', [
                'task[title]' => "Tâche sérieuse",
                'task[content]' => "C'est sérieux"]
        );
        $crawler = $this->client->followRedirect();
        $this->assertEquals('http://localhost/tasks', $crawler->getUri());
    }

    private function createTask($title, $content): Task
    {
        $task = new Task();
        $task->setTitle($title);
        $task->setContent($content);
        $task->setAuthor($this->admin);

        return $task;
    }
}