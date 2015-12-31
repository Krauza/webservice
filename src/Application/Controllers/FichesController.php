<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Exceptions\InvalidParameter;
use Fiche\Domain\Service\Exceptions\DataNotValid;
use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;

class FichesController extends Controller
{
    public function index()
    {
        return [];
    }

    public function create()
    {
        if($this->request->isMethod('POST')) {
            return $result = $this->save();
        }

        return $this->app->redirect('/groups');
    }

    public function edit($id)
    {
        $id = intval($id);
        if($id === 0) {
            throw new InvalidParameter;
        }

        $group = $this->storage->getById(Fiche::class, $id);
        $result = [
            'group' => $group
        ];

        if($this->request->isMethod('PUT')) {
            $result = $this->save($group);
        }

        return $result;
    }

    private function save(Fiche $fiche = null)
    {
        $word = $this->request->get('word');
        $explain = $this->request->get('explain');
        $group = $this->storage->getById(
            Group::class,
            intval($this->request->get('group'))
        );

        try {
            if(empty($fiche)) {
                $fiche = new Fiche(null, $group, $word, $explain);
                $this->storage->insert($fiche);
            } else {
                $fiche->setWord($word);
                $fiche->setExplainWord($explain);
                $this->storage->update($fiche);
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

        return [];
    }
}
