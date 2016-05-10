<?php

namespace Fiche\Domain\Service;

class UserFichesAtLevelFilter extends \FilterIterator
{
    private $level;

    public function __construct(UserFichesCollection $collection, int $level)
    {
        parent::__construct($collection->getIterator());
        $this->level = $level;
    }

    public function accept()
    {
        $userFiche = $this->current();
        if($userFiche->getLevel() === $this->level) {
            return true;
        }

        return false;
    }
}
