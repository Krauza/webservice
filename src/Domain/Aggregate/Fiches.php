<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Service\AggregateInterface;

class Fiches extends \ArrayObject implements AggregateInterface
{
    public function getEntityClass()
    {

    }
}