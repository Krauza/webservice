<?php

namespace Fiche\Domain\Service;

interface StorageInterface
{
    public function fetchAll(AggregateInterface $arrayObject, $options = []);
    public function insert(Entity $entity);
}
