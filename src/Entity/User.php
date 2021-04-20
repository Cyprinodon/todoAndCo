<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = ["ROLE_USER"];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        //Le rôle ROLE_USER doit toujours figurer dans la liste des rôles.
        if(in_array("ROLE_USER", $roles)) {
            $this->roles = $roles;
        }
        else {
            $this->roles = array_merge($roles, ["ROLE_USER"]);
        }
    }

    public function addRole(string $role)
    {
        if(in_array($role, $this->roles)) {
            return;
        }

        array_push($this->roles, $role);
    }

    public function removeRole(string $role)
    {
        if(!in_array($role, $this->roles)) {
            return;
        }

        $roles = array_filter($this->roles, function ($roleEntry) use ($role) {
            return $roleEntry != $role;
        });
        $this->roles = $roles;
    }

    public function eraseCredentials()
    {
    }
}
