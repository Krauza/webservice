<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Policy\UniqueIdInterface;
use Fiche\Domain\ValueObject\FicheExplain;
use Fiche\Domain\ValueObject\FicheWord;

class Fiche extends Entity
{
    private $word;
    private $explain_word;
    private $attachment;
    private $group;

    public function __construct(UniqueIdInterface $id, Group $group, FicheWord $word, FicheExplain $explain, Attachment $attachment = null)
    {
        $this->id = $id;
        $this->group = $group;
        $this->word = $word;
        $this->explain_word = $explain;
        $this->attachment = $attachment;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getExplainWord(): string
    {
        return $this->explain_word;
    }

    public function getAttachment(): Attachment
    {
        return $this->attachment;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getGroupId(): int
    {
        return $this->getGroup()->getId();
    }
}
