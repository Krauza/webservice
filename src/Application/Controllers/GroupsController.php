<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Models\Mysql\Group;

class GroupsController
{
    public function index(): array
    {
        $groups = Group::getAll();
        return array('groups' => $groups);
    }

    public function create(): array
    {

    }

    public function delete(): array
    {

    }

    public function edit(): array
    {

    }
}
