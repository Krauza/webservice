<?php

namespace Fiche\Application\Controllers;

class BaseController
{
    public function index()
    {
        return array(
            'name' => 'response from controller'
        );
    }
}
