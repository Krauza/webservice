<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Entity\User;
use Fiche\Application\Exceptions\RecordNotExists;

class AuthController extends Controller
{
    public function login()
    {
        if(!empty($this->currentUser)) {
            $this->app->redirect('/base');
        }

        if ($this->request->isMethod('POST')) {
            return $this->doLogin();
        }

        return [];
    }

    private function doLogin()
    {
        $user = null;

        try {
            $user = $this->storage->getByField(User::class, 'email', $this->request->get('email'));
        } catch(RecordNotExists $e) {
            return $this->returnErrorMessages([
                'field' => 'email',
                'message' => $e->getMessage()
            ]);
        }

        if($user->getPassword() !== UserController::passwordHash($this->request->get('password'))) {
            return $this->returnErrorMessages([
                'field' => 'password',
                'message' => 'Password is wrong'
            ]);
        }

        $this->setCurrentUser($user);
        return $this->app->redirect('/groups/index');
    }

    public function logout()
    {
        $this->logoutCurrentUser();
        return $this->app->redirect('/auth/login');
    }

    private function returnErrorMessages($messages)
    {
        return [
            'messages' => $messages,
            'data' => [
                'email' => $this->request->get('email')
            ]
        ];
    }
}
