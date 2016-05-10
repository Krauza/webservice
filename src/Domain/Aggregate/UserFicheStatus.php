<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Service\FicheLevelValue;

class UserFicheStatus
{
    private $fiche;
    private $level;
    private $position;
    private $archived;
    private $userGroup;

    public function __construct(Fiche $fiche, UserGroup $userGroup, int $level = 1, \DateTime $position, $archived = false)
    {
        $this->fiche = $fiche;
        $this->userGroup = $userGroup;
        $this->level = $level;
        $this->position = $position;
        $this->archived = $archived;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getFiche()
    {
        return $this->fiche;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function isArchived()
    {
        return $this->archived;
    }

    public function getUserGroup()
    {
        return $this->userGroup;
    }

    public function updateStatus($userKnown)
    {
        if(filter_var($userKnown, FILTER_VALIDATE_BOOLEAN)) {
            if($this->level >= FicheLevelValue::MAX_FICHE_LEVEL) {
                $this->archived = true;
            } else {
                $this->level++;
            }
        } else {
            $this->level = 1;
        }

        $this->position = new \DateTime(date("Y-m-d H:i:s") . substr((string)microtime(), 1, 8));
    }
}
