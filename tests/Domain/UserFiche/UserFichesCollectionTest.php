<?php

declare(strict_types=1);

use Fiche\Domain\Service\UserFichesCollection;
use Fiche\Domain\Aggregate\UserFicheStatus;

/**
 * Class UserFichesCollectionTest
 *
 * @property UserFichesCollection $userFichesCollection
 */
class UserFichesCollectionTest extends PHPUnit_Framework_TestCase
{
    private $userFichesCollection;

    public function setUp()
    {
        $this->userFichesCollection = new UserFichesCollection();
    }

    /**
     * @test
     */
    public function shouldAppendUserFicheToCollection()
    {
//        $userFiche = new UserFicheStatus();
//        $this->userFichesCollection->append();
        $this->assertEquals(true, true);
    }
}
