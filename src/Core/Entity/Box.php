<?php

namespace Krauza\Core\Entity;

use Krauza\Core\ValueObject\BoxName;
use Krauza\Core\ValueObject\EntityId;

class Box implements Entity
{
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

    public function __construct(BoxName $boxName, int $section = 0)
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
        $this->section = 0;
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
