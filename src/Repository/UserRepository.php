<?php

namespace Krauza\Repository;

use Krauza\Entity\User;

interface UserRepository
{
    public function __construct($engine);
    public function add(User $user);
}
