<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Exceptions\InvalidParameter;
use Fiche\Domain\Aggregate\Groups;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Service\Exceptions\DataNotValid;

/**
 * Class GroupsController
 * @package Fiche\Application\Controllers
 */
class GroupsController extends Controller
{
    public function index()
    {
        $groups = new Groups();
        $this->storage->fetchAll($groups, [
            'where' => [
                'owner_id' => $this->currentUser->getId()
            ]
        ]);

        return ['groups' => $groups];
    }

    public function show($id)
    {
        $group = $this->storage->getById(Group::class, $this->convertIdToInt($id));
        return ['group' => $group];
    }

    public function create()
    {
        $result = [];

        if ($this->request->isMethod('POST')) {
            $result = $this->save();
        }

        return $result;
    }

    public function edit($id)
    {
        $group = $this->storage->getById(Group::class, $this->convertIdToInt($id));
        $result = [
            'group' => $group
        ];

        if ($this->request->isMethod('PUT')) {
            $result = $this->save($group);
        }

        return $result;
    }

    public function delete($id)
    {
        if ($this->request->isMethod('DELETE')) {
            $group = $this->storage->getById(Group::class, $this->convertIdToInt($id));
            $this->storage->delete($group);
        }

        return $this->app->redirect('/groups');
    }

    public function fiches($id)
    {
        $group = $this->storage->getById(Group::class, $this->convertIdToInt($id));
        return ['group' => $group];
    }

    private function save(Group $group = null)
    {
        try {
            if (empty($group)) {
                $group = new Group(null, $this->request->get('name'));
                $this->storage->insert($group);
            } else {
                $group->setName($this->request->get('name'));
                $this->storage->update($group);
            }
        } catch(DataNotValid $e) {
            return [
                'messages' => [
                    'field' => $e->getFieldName(),
                    'message' => $e->getMessage()
                ],
                'data' => [
                    'name' => $this->request->get('name')
                ]
            ];
        }

        return $this->app->redirect('/groups');
    }
}
