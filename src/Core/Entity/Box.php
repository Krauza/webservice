<?php

namespace Krauza\Core\Entity;

use Krauza\Core\ValueObject\BoxName;
use Krauza\Core\ValueObject\EntityId;

class Box implements Entity
{
    const SECTION_THRESHOLDS = [50, 100, 200, 320, 500];
    const FIRST_SECTION = 0;
    const LAST_SECTION = 4;
    const REWIND_LIMIT = 40;
    const MAX_COUNT_OF_NEW_CARDS_FROM_INBOX = 20;

    /**
     * @var EntityId
     */
    private $id;

    /**
     * @var BoxName
     */
    private $name;

    /**
     * @var int
     */
    private $section;

    public function __construct(BoxName $boxName, int $section = self::FIRST_SECTION)
    {
        $this->name = $boxName;
        $this->section = $section;
    }

    public function setId(EntityId $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function incrementCurrentSection()
    {
        $this->section++;
    }

    public function rewindToFirstSection()
    {
        $this->section = self::FIRST_SECTION;
    }

    public function setCurrentSection(int $section)
    {
        $this->section = $section;
    }

    public function getCurrentSection(): int
    {
        return $this->section;
    }
}
