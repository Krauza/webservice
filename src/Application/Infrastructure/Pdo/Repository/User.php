<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Exceptions\RecordNotExists;
use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Factory\UserFactory;
use Fiche\Domain\Repository\UserRepository;
use Fiche\Domain\Entity\User as UserEntity;

class User implements PdoRepository, UserRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage) {
		$this->storage = $storage;
	}

	public function getById($id): UserEntity
	{
		$result = $this->storage->query(function($pdo, $operations) use($id) {
			$dbClass = $operations . '\\FetchData';
			$columns = ['name', 'email'];

			return $dbClass::getByField($pdo, $columns, 'user', 'id', $id);
		});

		$id = new UniqueId($id);
		$userGroups = new UserGroups($this->storage);

		return UserFactory::create($id, $result['name'], $result['email'], '', $userGroups);
	}

	public function getByEmail($email): UserEntity
	{
		$result = $this->storage->query(function($pdo, $operations) use($email) {
			$dbClass = $operations . '\\FetchData';
			$columns = ['id', 'name', 'email', 'password'];

			return $dbClass::getByField($pdo, $columns, 'user', 'email', $email);
		});

		if (!$result) {
			throw new RecordNotExists;
		}

		$id = new UniqueId($result['id']);
		$userGroups = new UserGroups($this->storage);

		return UserFactory::create($id, $result['name'], $result['email'], $result['password'], $userGroups);
	}

	public function insert(UserEntity $user)
	{
		return $this->storage->query(function($pdo, $operations) use ($user) {
			$dbClass = $operations . '\\ModifyData';
			return $dbClass::insert($pdo, 'user', [
				'id' => $user->getId(),
				'name' => $user->getName(),
				'email' => $user->getEmail(),
				'password' => $user->getPassword()
			]);
		});
	}
}
