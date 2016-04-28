<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\User;

class UserFicheStatus
{
    const MAX_FICHE_LEVEL = 5;
    const MAX_FICHES_PERCENTAGE_AT_LEVEL = 0.8;
    const FICHES_COUNT_AT_FIRST_LEVEL = 40;
    const FICHES_COUNT_AT_SECOND_LEVEL = 100;
    const FICHES_COUNT_AT_THIRD_LEVEL = 200;
    const FICHES_COUNT_AT_FOURTH_LEVEL = 350;
    const FICHES_COUNT_AT_FIFTH_LEVEL = 500;

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

    public static function maxFichesAtLevel(int $level)
    {
        $result = 0;

        switch($level) {
            case 1:
                $result = self::FICHES_COUNT_AT_FIRST_LEVEL;
                break;
            case 2:
                $result = self::FICHES_COUNT_AT_SECOND_LEVEL;
                break;
            case 3:
                $result = self::FICHES_COUNT_AT_THIRD_LEVEL;
                break;
            case 4:
                $result = self::FICHES_COUNT_AT_FOURTH_LEVEL;
                break;
            case 5:
                $result = self::FICHES_COUNT_AT_FIFTH_LEVEL;
                break;
        }

        $result *= UserFicheStatus::MAX_FICHES_PERCENTAGE_AT_LEVEL;

        return $result;
    }
}
