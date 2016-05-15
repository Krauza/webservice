<?php

require_once('SetupFiche.php');

use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Aggregate\UserFicheStatus;

trait SetupUserFiche
{
    use SetupFiche;

    private $level;
    private $lastModified;
    private $archived;

    private function setupUserFiche(UserGroup $userGroup)
    {
        $this->setupFiche($userGroup->getGroup());
        $this->level = 1;
        $this->lastModified = new DateTime();
        $this->archived = false;

        $this->userFiche = new UserFicheStatus($this->fiche, $userGroup, $this->level, $this->lastModified, $this->archived);
    }
}
