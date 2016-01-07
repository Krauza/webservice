<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Exceptions\RecordNotExists;
use Fiche\Domain\Service\StorageInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Fiche\Domain\Entity\User;
use Fiche\Application\Exceptions\InvalidParameter;

/**
 * Class Controller
 * @package Fiche\Application\Controllers
 *
 * @property Application $app;
 * @property StorageInterface $storage;
 * @property User $currentUser;
 */
abstract class Controller
{
	protected $app;
	protected $storage;
	protected $request;
	protected $currentUser;

	final public function __construct(Application $app, Request $request) {
		$this->app = $app;
		$this->storage = $app['storage'];
		$this->setCurrentUserById($app['session']->get('current_user_id'));
		$this->request = $request;
	}

	protected function setCurrentUserById($userId)
	{
		$result = null;

		if ($this->isCorrectId($userId)) {
			try {
				$result = $this->storage->getById(User::class, $userId);
			} catch(RecordNotExists $e) {
				$result = null;
			}
		}

		$this->currentUser = $result;
	}

	protected function setCurrentUser(User $user)
	{
		$this->app['session']->set('current_user_id', $user->getId());
		$this->currentUser = $user;
	}

	protected function logoutCurrentUser()
	{
		$this->app['session']->set('current_user_id', null);
		$this->currentUser = null;
	}

	protected function isCorrectId($id)
	{
		if(intval($id) <= 0) {
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
