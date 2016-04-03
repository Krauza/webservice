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
            $this->userFichesRepository->fetchAllActiveForUserGroup($this, $userFichesCollection);

            $this->userFichesCollection = $userFichesCollection;
        }

        return $this->userFichesCollection;
    }

    public function getNextFiche(): UserFicheStatus
    {
        $userFichesCollection = $this->getUserFichesCollection();
        $fiche = null;
        $fichesCountAtLevel = [];

        if($userFichesCollection->count() > 0) {
            for ($level = UserFicheStatus::MAX_FICHE_LEVEL; $level > 0; $level--) {
                $fichesCountAtLevel[$level] = $userFichesCollection->getFichesCountAtLevel($level);

                if ($fichesCountAtLevel[$level] >= UserFicheStatus::maxFichesAtLevel($level)) {
                    $fiche = $userFichesCollection->getFirstFromLevel($level);
                }
            }
        }

        if($fiche === null) $fiche = $this->addNewFichesFromBacklogAndGetFirst($userFichesCollection);
        if($fiche === null) $fiche = $this->getFicheFromMostFilledLevel($userFichesCollection, $fichesCountAtLevel);

        return ['fiche_status' => $fiche];
    }

    private function addNewFichesFromBacklogAndGetFirst(UserFichesCollection $userFichesCollection)
    {
        $this->userFichesRepository->createConnections($this, $userFichesCollection);
        return $userFichesCollection->getFirstFromLevel(1);
    }

    private function getFicheFromMostFilledLevel(UserFichesCollection $userFichesCollection, array $fichesCountAtLevel)
    {
        $level = array_search(max($fichesCountAtLevel), $fichesCountAtLevel);
        return $level > 1 ? $userFichesCollection->getFirstFromLevel($level) : null;
    }
}
