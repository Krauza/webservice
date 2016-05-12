<?php

namespace Fiche\Domain\Service;

class FicheLevelValue
{
    const MAX_FICHE_LEVEL = 5;
    const MAX_FICHES_PERCENTAGE_AT_LEVEL = 0.8;
    const FICHES_COUNT_AT_FIRST_LEVEL = 40;
    const FICHES_COUNT_AT_SECOND_LEVEL = 100;
    const FICHES_COUNT_AT_THIRD_LEVEL = 200;
    const FICHES_COUNT_AT_FOURTH_LEVEL = 350;
    const FICHES_COUNT_AT_FIFTH_LEVEL = 500;

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
            default:
                return $result;
        }

        $result *= self::MAX_FICHES_PERCENTAGE_AT_LEVEL;
        return $result;
    }
}
