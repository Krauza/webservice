<?php

namespace Krauza\Entity;

use Krauza\ValueObject\BoxName;
use Krauza\ValueObject\EntityId;

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

    public function __construct(BoxName $boxName, int $section = 1)
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

    public function getCurrentSection(): int
    {
        return $this->section;
    }
}
