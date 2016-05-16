<?php

namespace Fiche\Domain\Aggregate;

use Fiche\Domain\Entity\Group;
use Fiche\Domain\Entity\User;
use Fiche\Domain\Repository\UserFichesRepository;
use Fiche\Domain\Service\FicheLevelValue;
use Fiche\Domain\Service\UserFichesCollection;
use Fiche\Domain\Service\UserFichesAtLevelFilter;

class UserGroup
{
    private $user;
    private $group;
    private $userFichesCollection;
    private $fichesAtLevelIterators;

    public function __construct(User $user, Group $group, UserFichesRepository $userFichesRepository)
    {
        $this->user = $user;
        $this->group = $group;
        $this->userFichesCollection = null;
        $this->userFichesRepository = $userFichesRepository;
        $this->fichesAtLevelIterators = [];
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
        $this->getUserFichesCollection();

        $ficheStatus = $this->getFicheFromOverflowingLevel();
        if($ficheStatus === null) $ficheStatus = $this->addNewFichesFromBacklogAndGetFirst();
        if($ficheStatus === null) $ficheStatus = $this->getFicheFromMostFilledLevel();

        return $ficheStatus ? $ficheStatus->getFiche() : null;
    }

    private function getFicheFromOverflowingLevel()
    {
        if($this->userFichesCollection->count() > 0) {
            for ($level = FicheLevelValue::MAX_FICHE_LEVEL; $level > 0; $level--) {
                $iterator = new UserFichesAtLevelFilter($this->userFichesCollection, $level);
                $this->fichesAtLevelIterators[$level] = $iterator;

                if (iterator_count($iterator) >= FicheLevelValue::maxFichesAtLevel($level)) {
                    $iterator->rewind();
                    return $iterator->current();
                    break;
                }
            }
        }

        return null;
    }

    private function addNewFichesFromBacklogAndGetFirst()
    {
        $this->userFichesRepository->createConnections($this, $this->userFichesCollection);
        $iterator = new UserFichesAtLevelFilter($this->userFichesCollection, 1);
        $iterator->rewind();

        return $iterator->current();
    }

    private function getFicheFromMostFilledLevel()
    {
        $fichesCountAtLevel = array_map(function(\Iterator $iterator) {
            return iterator_count($iterator);
        }, $this->fichesAtLevelIterators);

        if(empty($fichesCountAtLevel)) {
            return null;
        }

        $level = array_search(max($fichesCountAtLevel), $fichesCountAtLevel);
        $this->fichesAtLevelIterators[$level]->rewind();
        return $level > 1 ? $this->fichesAtLevelIterators[$level]->current() : null;
    }
}
