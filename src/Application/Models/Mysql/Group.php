<?php

namespace Fiche\Application\Models\Mysql;

use Fiche\Domain\Service\StorageInterface;

class Group implements StorageInterface
{
    public static function getAll(): array
    {
        return array();
    }
}
