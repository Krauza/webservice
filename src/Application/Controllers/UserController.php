<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Infrastructure\Pdo\Repository\UserGroups;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Application\Infrastructure\Pdo\Repository\User as UserRepository;
use Fiche\Domain\Factory\UserFactory;
use Fiche\Domain\Service\Exceptions\DataNotValid;

class UserController extends BaseController
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
            $userRepository = new UserRepository($this->storage);
            $user = UserFactory::create(
                new UniqueId(),
                $this->request->get('name'),
                $this->request->get('email'),
                $this->request->get('password'),
                new UserGroups($this->storage)
            );

            $userRepository->insert($user);
        } catch(DataNotValid $e) {
            return $this->returnErrorMessages( [
                'field' => $e->getFieldName(),
                'message' => $e->getMessage()
            ]);
        }

        return $this->app->redirect('/groups/index');
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
