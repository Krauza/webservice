<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Policy\AggregateInterface;

class Fiches extends \ArrayObject implements AggregateInterface
{
    public function getEntityClass()
    {

    }
}