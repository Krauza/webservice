<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Infrastructure\DbPdoConnector;

interface PdoRepository
{
    public function __construct(DbPdoConnector $storage);
}