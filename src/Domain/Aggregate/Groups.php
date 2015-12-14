<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Service\AggregateInterface;

class Groups extends \ArrayObject implements AggregateInterface
{
    private $entityClass = Group::class;

    public function getEntityClass()
    {
        return $this->entityClass;
    }
}
