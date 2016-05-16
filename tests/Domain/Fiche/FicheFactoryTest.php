<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../traits/SetupGroup.php');

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Factory\FicheFactory;

/**
 * Class FicheFactoryTest
 *
 * @property Group $group
 */
class FicheFactoryTest extends PHPUnit_Framework_TestCase
{
    use SetupGroup;

    protected function setUp()
    {
        $this->setupGroup();
    }

    /**
     * @test
     */
    public function factoryShouldPrepareCorrectEntity()
    {
        $mockUniqueId = $this->getMock('Fiche\Domain\Policy\UniqueIdInterface');
        $id = new $mockUniqueId();
        $word = 'word';
        $explain = 'explain';

        $fiche = FicheFactory::create($id, $this->group, $word, $explain);

        $this->assertInstanceOf(Fiche::class, $fiche);
        $this->assertEquals($word, $fiche->getWord());
        $this->assertEquals($explain, $fiche->getExplainWord());
    }
}
