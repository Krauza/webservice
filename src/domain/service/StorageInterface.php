<?php

namespace Fiche\Domain\Service;

interface StorageInterface
{
    public static function getAll(): array;
}