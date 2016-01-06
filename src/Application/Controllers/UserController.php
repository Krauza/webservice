<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Entity\User;
use Fiche\Domain\Service\Exceptions\DataNotValid;

class UserController extends Controller
{
    public function register()
    {
        if (!empty($this->currentUser)) {
            return $this->app->redirect('/base');
        }

        if ($this->request->isMethod('POST')) {
            if (!$this->arePasswordsTheSame()) {
                return $this->returnErrorMessages([
                    'field' => 'password2',
                    'message' => 'This value must be the same like Password'
                ]);
            }

            return $this->doRegister();
        }

        return [];
    }

    private function doRegister()
    {
        try {
            $user = new User(
                null,
                $this->request->get('name'),
                $this->request->get('email'),
                password_hash($this->request->get('password'), PASSWORD_DEFAULT)
            );

            $this->storage->insert($user);
            $this->setCurrentUser($user);
        } catch(DataNotValid $e) {
            return $this->returnErrorMessages( [
                'field' => $e->getFieldName(),
                'message' => $e->getMessage()
            ]);
        }

        return $this->app->redirect('/base/index');
    }

    private function arePasswordsTheSame()
    {
        $password = $this->request->get('password');
        if (empty($password) || $password !== $this->request->get('password2')) {
            return false;
        }

        return true;
    }

    private function returnErrorMessages($messages)
    {
        return [
            'messages' => $messages,
            'data' => [
                'name' => $this->request->get('name'),
                'email' => $this->request->get('email')
            ]
        ];
    }
}
