<?php

namespace Fiche\Domain\Service;

interface StorageInterface
{
    public function getById(\string $className, $id);
    public function getByField(\string $className, \string $field, \string $value);
    public function fetchAll(AggregateInterface $arrayObject, array $options = []);
    public function insert(Entity $entity);
    public function update(Entity $entity);
    public function delete(Entity $entity);
}
