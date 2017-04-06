<?php

namespace Krauza\UseCase;

use Krauza\Factory\UserFactory;
use Krauza\Policy\IdPolicy;
use Krauza\Policy\PasswordPolicy;
use Krauza\Repository\UserRepository;

class RegisterUser
{
    private $userRepository;
    private $passwordPolicy;
    private $idPolicy;

    public function __construct(UserRepository $userRepository, PasswordPolicy $passwordPolicy, IdPolicy $idPolicy)
    {
        $this->userRepository = $userRepository;
        $this->passwordPolicy = $passwordPolicy;
        $this->idPolicy = $idPolicy;
    }

    public function register(array $data)
    {
        $user = UserFactory::createUser($data, $this->passwordPolicy, $this->idPolicy);
        $this->userRepository->add($user);
    }
}
