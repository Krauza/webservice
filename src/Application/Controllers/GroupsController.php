<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Aggregate\Groups;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Service\Exceptions\DataNotValid;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = new Groups();
        $this->storage->fetchAll($groups);
        return ['groups' => $groups];
    }

    public function create()
    {
        if($this->request->isMethod('POST')) {
            try {
                $group = new Group(null, $this->request->get('name'));
                $this->storage->insert($group);
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

        return [];
    }

    public function delete()
    {

    }

    public function edit()
    {

    }
}
