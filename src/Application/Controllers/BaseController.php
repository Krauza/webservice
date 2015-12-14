<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Aggregate\Groups;

class BaseController extends Controller
{
    public function index()
    {
        $groups = new Groups();
        $this->storage->fetchAll($groups);
        return array();
    }
}
