<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Aggregate\Groups;

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

    }

    public function delete(): array
    {

    }

    public function edit(): array
    {

    }
}
