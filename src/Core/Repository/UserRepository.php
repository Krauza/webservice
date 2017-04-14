<?php

namespace Krauza\Core\Repository;

use Krauza\Core\Entity\User;

interface UserRepository
{
    public function __construct($engine);
    public function add(User $user);
}
