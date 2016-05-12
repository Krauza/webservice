<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../traits/SetupGroup.php');

use Fiche\Domain\Service\FicheLevelValue;

/**
 * Class FicheFactoryTest
 *
 * @property Group $group
 */
class FicheLevelFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnCorrectMaxValueForFirstLevel()
    {
        $this->assertEquals(
            $this->getMaxValue(FicheLevelValue::FICHES_COUNT_AT_FIRST_LEVEL),
            FicheLevelValue::maxFichesAtLevel(1)
        );
    }

    /**
     * @test
     */
    public function shouldReturnCorrectMaxValueForSecondLevel()
    {
        $this->assertEquals(
            $this->getMaxValue(FicheLevelValue::FICHES_COUNT_AT_SECOND_LEVEL),
            FicheLevelValue::maxFichesAtLevel(2)
        );
    }

    /**
     * @test
     */
    public function shouldReturnCorrectMaxValueForThirdLevel()
    {
        $this->assertEquals($this->getMaxValue(
            FicheLevelValue::FICHES_COUNT_AT_THIRD_LEVEL),
            FicheLevelValue::maxFichesAtLevel(3)
        );
    }

    /**
     * @test
     */
    public function shouldReturnCorrectMaxValueForFourthLevel()
    {
        $this->assertEquals(
            $this->getMaxValue(FicheLevelValue::FICHES_COUNT_AT_FOURTH_LEVEL),
            FicheLevelValue::maxFichesAtLevel(4)
        );
    }

    /**
     * @test
     */
    public function shouldReturnCorrectMaxValueForFifthLevel()
    {
        $this->assertEquals(
            $this->getMaxValue(FicheLevelValue::FICHES_COUNT_AT_FIFTH_LEVEL),
            FicheLevelValue::maxFichesAtLevel(5)
        );
    }

    /**
     * @test
     */
    public function shouldReturnZeroForUnknownLevel()
    {
        $this->assertEquals(0, FicheLevelValue::maxFichesAtLevel(-6));
        $this->assertEquals(0, FicheLevelValue::maxFichesAtLevel(0));
        $this->assertEquals(0, FicheLevelValue::maxFichesAtLevel(25));
    }

    private function getMaxValue($countAtLevel)
    {
        return $countAtLevel * FicheLevelValue::MAX_FICHES_PERCENTAGE_AT_LEVEL;
    }
}
