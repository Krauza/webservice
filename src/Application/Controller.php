<?php

namespace Fiche\Application;

use Fiche\Application\Exceptions\RecordNotExists;
use Fiche\Application\Infrastructure\UniqueId;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Fiche\Domain\Entity\User;
use Fiche\Application\Infrastructure\Pdo\Repository\User as UserRepository;
use Fiche\Application\Exceptions\InvalidParameter;

/**
 * Class Controller
 * @package Fiche\Application\Controllers
 *
 * @property Application $app;
 * @property User $currentUser;
 */
abstract class Controller
{
	protected $app;
	protected $storage;
	protected $request;
	protected $currentUser;
	protected $session;

	final public function __construct(Application $app, Request $request) {
		$this->app = $app;
		$this->storage = $app['storage'];
		$this->session = new SessionStorage($app['session']);
		$this->setCurrentUserById($this->session->get('current_user_id'));
		$this->request = $request;
	}

	protected function setCurrentUserById($userId)
	{
		$result = null;

		if ($this->isCorrectId($userId)) {
			try {
				$userRepository = new UserRepository($this->storage);
				$result = $userRepository->getById($userId);
			} catch(RecordNotExists $e) {
				$result = null;
				$this->logoutCurrentUser();
			}
		}

		$this->currentUser = $result;
	}

	protected function setCurrentUser(User $user = null)
	{
		$this->session->set('current_user_id', $user->getId());
		$this->currentUser = $user;
	}

	public function getCurrentUser(): User
	{
		if(!$this->isUserLogged()) {
			throw new InvalidParameter();
		}

		return $this->currentUser;
	}

	public function isUserLogged(): bool
	{
		if(empty($this->currentUser)) {
			return false;
		}

		return true;
	}

	protected function logoutCurrentUser()
	{
		$this->session->set('current_user_id', null);
		$this->currentUser = null;
	}

	protected function isCorrectId($id)
	{
		if(empty($id)) {
			return false;
		}

		return true;
	}

	protected function convertIdToInt($id)
	{
		$id = intval($id);
		if ($id === 0) {
			throw new InvalidParameter;
		}

		return $id;
	}
}
