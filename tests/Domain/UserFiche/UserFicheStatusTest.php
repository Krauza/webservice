<?php

declare(strict_types=1);

use Fiche\Domain\Aggregate\UserFicheStatus;

/**
 * Class UserFicheStatusTest
 *
 * @property UserFichesCollection $userFichesCollection
 */
class UserFicheStatusTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

    }

    /**
     * @test
     */
    public function shouldAppendUserFicheToCollection()
    {
        $this->assertEquals(true, true);
    }
}
