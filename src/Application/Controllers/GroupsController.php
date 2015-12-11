<?php

namespace Fiche\Application\Controllers;

class GroupsController extends Controller
{
    public function index(): array
    {
        $groups = "";//Group::getAll();
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
