<?php


namespace App\Tests;


use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class AbstractWebTestCase extends WebTestCase
{
    protected KernelBrowser $client;
    protected EntityManagerInterface $entityManager;
    protected EncoderFactoryInterface $encoderFactory;
    protected TaskRepository $taskRepository;
    protected UserRepository $userRepository;

    const ADMIN_NAME = "testministrateur";
    const ADMIN_PASS = "test";
    const ADMIN_MAIL = "test@test.com";
    const ADMIN_ROLES = ["ROLE_ADMIN", "ROLE_USER"];

    /**
     * @throws ToolsException
     * @var EntityManagerInterface
     * @var TaskRepository
     * @var EncoderFactoryInterface
     * @var UserRepository
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
        self::bootKernel();
        $container = self::$container;
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->encoderFactory = $container->get('security.encoder_factory');
        $this->taskRepository = $container->get('App\Repository\TaskRepository');
        $this->userRepository = $container->get('App\Repository\UserRepository');
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->dropSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
        $schemaTool->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
    }

    public function login(string $username, string $password): ?Crawler
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Se connecter', [
            '_username' => $username,
            '_password' => $password,
        ]);

        return $this->client->followRedirect();
    }

    protected function createUser(string $username, string $password, string $email, ?array $roles = ['ROLE_USER']) :User
    {
        $user = new User();
        $user->setUsername($username);
        $passwordEncoder = $this->encoderFactory->getEncoder(User::class);
        $user->setPassword($passwordEncoder->encodePassword($password, ''));
        $user->setEmail($email);
        $user->setRoles($roles);

        return $user;
    }
}