<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Aggregate\Groups;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Service\Exceptions\FormNotValid;

class GroupsController extends Controller
{
    public function index(): array
    {
        $groups = new Groups();
        $this->storage->fetchAll($groups);
        return array('groups' => $groups);
    }

    public function create(): array
    {
        if($this->request->isMethod('POST')) {
            try {
                $group = new Group(null, $this->request->get('name'));
                $this->storage->insert($group);
            } catch(FormNotValid $e) {

            }
        }

        return array();
    }

    public function delete(): array
    {

    }

    public function edit(): array
    {

    }
}
