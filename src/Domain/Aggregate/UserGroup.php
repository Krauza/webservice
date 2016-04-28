<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;
use Fiche\Domain\Repository\UserFichesRepository;
use Fiche\Domain\Service\UserFichesCollection;
use Fiche\Domain\Service\UserFichesAtLevelFilter;

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

    public function getNextFiche()
    {
        $fiche = null;
        $ficheStatus = null;
        $userFichesCollection = $this->getUserFichesCollection();
        $fichesAtLevelIterators = [];

        if($userFichesCollection->count() > 0) {
            for ($level = UserFicheStatus::MAX_FICHE_LEVEL; $level > 0; $level--) {
                $iterator = new UserFichesAtLevelFilter($userFichesCollection, $level);
                $fichesAtLevelIterators[$level] = $iterator;

                if (iterator_count($iterator) >= UserFicheStatus::maxFichesAtLevel($level)) {
                    $iterator->rewind();
                    $ficheStatus = $iterator->current();
                    break;
                }
            }
        }

        if($ficheStatus === null) $ficheStatus = $this->addNewFichesFromBacklogAndGetFirst($userFichesCollection);
        if($ficheStatus === null) $ficheStatus = $this->getFicheFromMostFilledLevel($fichesAtLevelIterators);

        if($ficheStatus) {
            $fiche = $ficheStatus->getFiche();
        }

        return $fiche;
    }

    private function addNewFichesFromBacklogAndGetFirst(UserFichesCollection $userFichesCollection)
    {
        $this->userFichesRepository->createConnections($this, $userFichesCollection);
        $iterator = new UserFichesAtLevelFilter($userFichesCollection, 1);
        $iterator->rewind();

        return $iterator->current();
    }

    private function getFicheFromMostFilledLevel(array $fichesAtLevelIterators)
    {
        $fichesCountAtLevel = array_map(function(\Iterator $iterator) {
            return iterator_count($iterator);
        }, $fichesAtLevelIterators);

        if(empty($fichesCountAtLevel)) {
            return null;
        }

        $level = array_search(max($fichesCountAtLevel), $fichesCountAtLevel);
        return $level > 1 ? $fichesAtLevelIterators[$level]->current() : null;
    }
}
