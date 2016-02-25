<?php

namespace Fiche\Domain\Entity;

class UserFicheStatus extends Entity
{
    const MAX_FICHE_LEVEL = 5;
    const FICHES_COUNT_AT_FIRST_LEVEL = 40;

    private $id;
    private $user;
    private $fiche;
    private $level;
    private $position;
    private $archived;

    public function __construct($id = null, User $user, Fiche $fiche, $level = 0, $position = null, $archived = false)
    {
        $this->setId($id);
        $this->user = $user;
        $this->fiche = $fiche;
        $this->level = $level;
        $this->position = $position;
        $this->archived = $archived;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getFiche()
    {
        return $this->fiche;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function isArchived()
    {
        return $this->archived;
    }

    public static function getFieldsNames(): array
    {
        // TODO: Implement getFieldsNames() method.
    }

    public function getValues(): array
    {
        // TODO: Implement getValues() method.
    }

    public function setId( $id = null)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
