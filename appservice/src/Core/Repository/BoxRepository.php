<?php

namespace Krauza\Core\Repository;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\User;

interface BoxRepository
{
    public function __construct($engine);
    public function add(Box $box, User $user);
    public function getById(string $id): Box;
    public function getAllForUser(User $user): array;
    public function updateBoxSection(Box $box);
}
