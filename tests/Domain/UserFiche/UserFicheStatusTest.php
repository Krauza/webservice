<?php

declare(strict_types=1);
require(__DIR__ . '/../../traits/SetupUserGroup.php');
require(__DIR__ . '/../../traits/SetupUserFiche.php');

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Aggregate\UserFicheStatus;

/**
 * Class UserFicheStatusTest
 *
 * @property UserFicheStatus $userFiche
 * @property Fiche $fiche
 */
class UserFicheStatusTest extends PHPUnit_Framework_TestCase
{
    use SetupUserGroup, SetupUserFiche;

    public function setUp()
    {
        $this->setupUserGroup();
        $this->setupUserFiche($this->userGroup);
    }

    /**
     * @test
     */
    public function shouldHasCorrectLevel()
    {
        $this->assertEquals($this->level, $this->userFiche->getLevel());
    }

    /**
     * @test
     */
    public function shouldHasCorrectFiche()
    {
        $this->assertEquals($this->fiche, $this->userFiche->getFiche());
    }

    /**
     * @test
     */
    public function shouldReturnCorrectArchivedStatus()
    {
        $this->assertEquals($this->archived, $this->userFiche->isArchived());
    }

    /**
     * @test
     */
    public function shouldHasCorrectLastModifiedTime()
    {
        $this->assertEquals($this->lastModified, $this->userFiche->getPosition());
    }

    /**
     * @test
     */
    public function shouldHasCorrectUserGroup()
    {
        $this->assertEquals($this->userGroup, $this->userFiche->getUserGroup());
    }

    /**
     * @test
     */
    public function shouldCorrectUpdateStatusOfFiche()
    {
        $this->userFiche->updateStatus(true);
        $level = $this->level + 1;

        $this->assertEquals($level, $this->userFiche->getLevel());
        $this->assertGreaterThan($this->lastModified, $this->userFiche->getPosition());

        $lastModified = $this->userFiche->getPosition();

        $this->userFiche->updateStatus(false);
        $this->assertEquals(1, $this->userFiche->getLevel());
        $this->assertGreaterThan($lastModified, $this->userFiche->getPosition());
    }

    /**
     * @test
     */
    public function shouldCorrectlyMoveFicheToArchive()
    {
        for($i = 0; $i < \Fiche\Domain\Service\FicheLevelValue::MAX_FICHE_LEVEL; $i++) {
            $this->userFiche->updateStatus(true);
        }

        $this->assertTrue($this->userFiche->isArchived());
    }
}
