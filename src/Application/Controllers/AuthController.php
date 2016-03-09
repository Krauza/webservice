<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Infrastructure\Pdo\Repository\User as UserRepository;
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
            $userRepository = new UserRepository($this->storage);
            $user = $userRepository->getByEmail($this->request->get('email'));
        } catch(RecordNotExists $e) {
            return $this->returnErrorMessages([
                'field' => 'email',
                'message' => $e->getMessage()
            ]);
        }

        if(password_verify($this->request->get('password'), $user->getPassword())) {
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
