<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $data;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->data = [
            "users" => [
                "administrator" => [
                    "username" => "Administrateur",
                    "email" => "ocdummy.master@gmail.com",
                    "password" => "admin",
                    "role" => "ROLE_ADMIN"
                ],
            ],
            "tasks" => [
               [
                   "title" => "Faire un truc",
                   "content" => "Il est important de faire des trucs, dans la vie.",
                   "hasAuthor" => true
               ], [
                    "title" => "Faire un autre truc",
                    "content" =>"Quand faire un truc n'est pas assez.",
                    "hasAuthor" => true
                ], [
                    "title" => "Faire un truc incognito",
                    "content" =>"Aucune idée de qui veut faire ce truc."
                ], [
                    "title" => "Faire un machin",
                    "content" =>"Pour ceux qui n'aiment pas faire des trucs.",
                    "hasAuthor" => true
                ], [
                    "title" => "Un truc a été fait",
                    "content" =>"C'est validé, donc c'est fait.",
                    "isDone" => true,
                    "hasAuthor" => true
                ], [
                    "title" => "Faire semblant",
                    "content" =>"C'est une question de principe.",
                    "isDone" => true
                ],
            ]
        ];
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->data["users"];
        $authors = [];
        foreach($users as $userData) {
            $user = new User();
            $user->setUsername($userData["username"]);
            $user->setEmail($userData["email"]);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $userData["password"]));

            if(array_key_exists("role", $userData)) {
                $user->addRole($userData["role"]);
            }
            $manager->persist($user);
            array_push($authors, $user);
        }

        $tasks = $this->data["tasks"];
        foreach($tasks as $taskData) {
            $task = new Task();
            $task->setTitle($taskData["title"]);
            $task->setContent($taskData["content"]);

            if(array_key_exists("hasAuthor", $taskData) && $taskData["hasAuthor"]) {
                $task->setAuthor($authors[array_rand($authors)]);
            }

            if(array_key_exists("isDone", $taskData)) {
                $task->toggle($taskData["isDone"]);
            }
            $manager->persist($task);
        }
        $manager->flush();
    }
}
