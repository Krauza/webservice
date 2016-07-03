<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Exceptions\InvalidParameter;
use Fiche\Application\Infrastructure\Pdo\Repository\Fiches as FicheRepository;
use Fiche\Application\Infrastructure\Pdo\Repository\Fiches;
use Fiche\Application\Infrastructure\Pdo\Repository\Group as GroupRepository;
use Fiche\Application\Infrastructure\Pdo\Repository\UserFiches;
use Fiche\Application\Infrastructure\Pdo\Repository\UserGroups;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Factory\FicheFactory;
use Fiche\Domain\Service\Exceptions\DataNotValid;
use Fiche\Domain\Entity\Fiche;

class FichesController extends BaseController
{
    public function create()
    {
        if ($this->request->isMethod('POST')) {
            return $this->save();
        }

        return $this->app->redirect('/groups');
    }

    public function lesson($groupId)
    {
        $groupRepository = new GroupRepository($this->storage);
        $userGroupRepository = new UserGroups($this->storage);

        $group = $groupRepository->getById($groupId);
        $userGroup = $userGroupRepository->getByGroupForUser($group, $this->currentUser);

        return [
            'group' => $group,
            'fiche' => $userGroup->getNextFiche()
        ];
    }

    public function answer()
    {
        if($this->request->isMethod('POST')) {
            $fichesRepository = new Fiches($this->storage);
            $userFichesRepository = new UserFiches($this->storage);

            $fiche = $fichesRepository->getById($this->request->get('fiche_id'));
            $userFiche = $userFichesRepository->fetchByFicheForUser($this->currentUser, $fiche);
            $userFiche->updateStatus($this->request->get('user_known'));
            $userFichesRepository->update($userFiche);

            return $this->app->redirect('/fiches/lesson/' . $userFiche->getUserGroup()->getGroup()->getId());
        }

        throw new InvalidParameter;
    }

    private function save(Fiche $fiche = null)
    {
        $ficheRepository = new FicheRepository($this->storage);
        $groupRepository = new GroupRepository($this->storage);

        $word = $this->request->get('word');
        $explain = $this->request->get('explain');
        $group = $groupRepository->getById($this->request->get('group'));

        try {
            if (empty($fiche)) {
                $fiche = FicheFactory::create(new UniqueId(), $group, $word, $explain);
                $ficheRepository->insert($fiche);
            }
        } catch(DataNotValid $e) {
            return [
                'messages' => [
                    'field' => $e->getFieldName(),
                    'message' => $e->getMessage()
                ],
                'data' => [
                    'word' => $word,
                    'explain' => $explain
                ]
            ];
        }

        return $this->app->redirect('/groups/show/' . $group->getId());
    }
}
