<?php

namespace Fiche\Application\Infrastructure;

use Fiche\Domain\Policy\UniqueIdInterface;

class UniqueId implements UniqueIdInterface
{
    private $id;

    public function __construct($id = null)
    {
        if($id === null) {
            $this->generate();
        } else {
            $this->id = $id;
        }
    }

    public function generate()
    {
        $this->id = uniqid();
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
