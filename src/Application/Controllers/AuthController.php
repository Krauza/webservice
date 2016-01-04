<?php

namespace Fiche\Application\Controllers;

class AuthController extends Controller
{
    public function loginForm()
    {
        return [];
    }

    public function login()
    {
        return $this->app->redirect('/base/index');
    }

    public function logout()
    {
        return $this->app->redirect('/auth/login-form');
    }
}
