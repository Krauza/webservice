<?php

namespace Fiche\Application\Controllers;

use Fiche\Application\Exceptions\RecordNotExists;
use Fiche\Domain\Service\StorageInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Fiche\Domain\Entity\User;

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

	private function setCurrentUserById($userId)
	{
		$result = null;
		$userId = intval($userId);

		if($userId > 0) {
			try {
				echo $userId;
				$result = $this->storage->getById(User::class, $userId);
			} catch(RecordNotExists $e) {
				$result = null;
			}
		}

		$this->currentUser = $result;
	}

	public function setCurrentUser(User $user)
	{
		$this->app['session']->set('current_user_id', $user->getId());
		$this->currentUser = $user;
	}
}
