<?php

namespace App\Helper;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory implements IEntity
{

    private UserPasswordHasherInterface $password_hasher;

    public function __construct(UserPasswordHasherInterface $password_hasher)
    {
        $this->password_hasher = $password_hasher;
    }

    public function create(array $data):User
    {
        $user = new User();
        $user->setNome($data["name"])->setEmail($data["email"])->setUsername($data["username"])->setPassword($this->password_hasher->hashPassword($user, $data["password"]));
        return $user;
    }
}