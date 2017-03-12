<?php

namespace Krauza\Service;

use Krauza\Factory\UserFactory;
use Krauza\Policy\PasswordPolicy;
use Krauza\Repository\UserRepository;

class RegistrationService
{
    private $userRepository;
    private $passwordPolicy;

    public function __construct(UserRepository $userRepository, PasswordPolicy $passwordPolicy)
    {
        $this->userRepository = $userRepository;
        $this->passwordPolicy = $passwordPolicy;
    }

    public function register(array $data)
    {
        $user = UserFactory::createUser($data, $this->passwordPolicy);
        $this->userRepository->add($user);
    }
}
