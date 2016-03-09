<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\User;

class UserFicheStatus
{
    const MAX_FICHE_LEVEL = 5;
    const FICHES_COUNT_AT_FIRST_LEVEL = 40;

    private $user;
    private $fiche;
    private $level;
    private $position;
    private $archived;
    private $userGroup;

    public function __construct(User $user, Fiche $fiche, UserGroup $userGroup, $level = 0, $position = null, $archived = false)
    {
        $this->user = $user;
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

    public function getUser()
    {
        return $this->user;
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
}
