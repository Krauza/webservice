<?php

namespace Fiche\Domain\Service;

interface StorageInterface
{
    public function fetchAll($command, $arrayObject);
}