<?php

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\ValueObject\Attachment;
use Fiche\Domain\ValueObject\FicheWord;
use Fiche\Domain\ValueObject\FicheExplain;
use Fiche\Domain\Policy\UniqueIdInterface;

trait SetupFiche
{
    private $fiche;
    private $word;
    private $explain;
    private $ficheId;
    private $attachment;

    private function setupFiche(Group $group)
    {
        $mockUniqueId = $this->getMock(UniqueIdInterface::class);

        $this->ficheId = new $mockUniqueId();
        $this->word = new FicheWord('word');
        $this->explain = new FicheExplain('słowo');
        $this->attachment = new Attachment('file.jpg', 'dir');

        $this->fiche = new Fiche($this->ficheId, $group, $this->word, $this->explain, $this->attachment);
    }
}
