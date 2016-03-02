<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Entity\Group as GroupEntity;
use Fiche\Domain\Repository\GroupRepository;
use Fiche\Domain\ValueObject\GroupName;

class Group implements PdoRepository, GroupRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage) {
		$this->storage = $storage;
	}

	public function getById($id): GroupEntity
	{
		$result = $this->storage->query(function($pdo, $operations) use ($id) {
			$dbClass = $operations . '\\FetchData';
			$columns = ['owner_id', 'name'];

			return $dbClass::getByField($pdo, $columns, 'group', 'id', $id);
		});

		$userRepository = new User($this->storage);
		$owner = $userRepository->getById($result['owner_id']);
		$id = new UniqueId($id);

		return new GroupEntity($id, $owner, new GroupName($result['name']), new Fiches($this->storage));
	}

	public function insert(GroupEntity $group)
	{
		return $this->storage->query(function($pdo, $operations) use ($group) {
			$dbClass = $operations . '\\ModifyData';

			$data = [
				'id' => $group->getId(),
				'owner_id' => $group->getOwner()->getId(),
				'name' => $group->getName()
			];

			return $dbClass::insert($pdo, 'group', $data);
		});
	}

	public function update(GroupEntity $group)
	{
		return $this->storage->query(function($pdo, $operations) use ($group) {
			$dbClass = $operations . '\\ModifyData';

			$data = [
				'name' => $group->getName()
			];

			return $dbClass::update($pdo, 'group', $data, $group->getId());
		});
	}
}
