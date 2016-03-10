<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;
use Fiche\Domain\Repository\UserFichesRepository;
use Fiche\Domain\Service\UserFichesCollection;

class UserGroup
{
    private $user;
    private $group;
    private $userFichesCollection;

    public function __construct(User $user, Group $group, UserFichesRepository $userFichesRepository)
    {
        $this->user = $user;
        $this->group = $group;
        $this->userFichesCollection = null;
        $this->userFichesRepository = $userFichesRepository;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getUserFichesCollection(): UserFichesCollection
    {
        if($this->userFichesCollection === null) {
            $userFichesCollection = new UserFichesCollection();
            $this->userFichesRepository->createConnections($this, $userFichesCollection);

            $this->userFichesCollection = $userFichesCollection;
        }

        return $this->userFichesCollection;
    }

    public function getNextFiche(): UserFicheStatus
    {
        $userFichesCollection = $this->getUserFichesCollection();

        for($level = UserFicheStatus::MAX_FICHE_LEVEL; $level > 0; $level--) {
            if($userFichesCollection->getFichesCountAtLevel($level) >= UserFicheStatus::maxFichesAtLevel($level) * UserFicheStatus::MAX_FICHES_PERCENTAGE_AT_LEVEL) {

            }
        }
    }
}
