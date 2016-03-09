<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Infrastructure\Pdo\Repository\Fiches as FicheRepository;
use Fiche\Application\Infrastructure\Pdo\Repository\Group as GroupRepository;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Factory\FicheFactory;
use Fiche\Domain\Service\Exceptions\DataNotValid;
use Fiche\Domain\Entity\Fiche;

class FichesController extends Controller
{
    public function create()
    {
        if ($this->request->isMethod('POST')) {
            return $this->save();
        }

        return $this->app->redirect('/groups');
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
