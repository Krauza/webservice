<?php

namespace Fiche\Application\Controllers;

use Fiche\Domain\Entity\User;
use Fiche\Domain\Service\Exceptions\DataNotValid;

class UserController extends Controller
{
    public function register()
    {
        if($this->request->isMethod('POST')) {
            $password = $this->request->get('password');
            if(empty($password) ||$password !== $this->request->get('password2')) {
                return [
                    'messages' => [
                        'field' => 'password2',
                        'message' => 'This value must be the same like Password'
                    ],
                    'data' => [
                        'name' => $this->request->get('name'),
                        'email' => $this->request->get('email')
                    ]
                ];
            }

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
                return [
                    'messages' => [
                        'field' => $e->getFieldName(),
                        'message' => $e->getMessage()
                    ],
                    'data' => [
                        'name' => $this->request->get('name'),
                        'email' => $this->request->get('email')
                    ]
                ];
            }


            return $this->app->redirect('/base/index');
        }

        return [];
    }
}
