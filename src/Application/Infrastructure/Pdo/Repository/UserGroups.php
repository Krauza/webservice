<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Exceptions\RecordNotExists;
use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Repository\UserGroupsRepository;
use Fiche\Domain\Entity\User as UserEntity;
use Fiche\Domain\Service\UserGroupsCollection;
use Fiche\Domain\ValueObject\GroupName;
use Guzzle\Http\Exception\RequestException;

class UserGroups implements PdoRepository, UserGroupsRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage) {
		$this->storage = $storage;
	}

	public function insert(Group $group, UserEntity $user): UserGroup
	{
		$result = $this->storage->query(function($pdo, $operations) use ($group, $user) {
			$dbClass = $operations . '\\ModifyData';
			return $dbClass::insert($pdo, 'user_group', [
				'user_id' => $user->getId(),
				'group_id' => $group->getId()
			]);
		});

		if(!$result) {
			throw new RequestException;
		}

		return new UserGroup($user, $group, new UserFiches($this->storage));
	}

	public function getByGroupForUser(Group $group, UserEntity $user): UserGroup
	{
		$result = $this->storage->query(function($pdo, $operations) use ($group, $user) {
			$dbClass = $operations . '\\FetchData';

			return $dbClass::getRow($pdo, ['*'], 'user_group', [
				'group_id' => $group->getId(),
				'user_id' => $user->getId()
			]);
		});

		if(empty($result)) {
			throw new RecordNotExists;
		}

		return new UserGroup($user, $group, new UserFiches($this->storage));
	}

	public function fetchAllForUser(UserEntity $user, UserGroupsCollection $userGroupsCollection)
	{
		$result = $this->storage->query(function($pdo, $operations) use($user) {
			$dbClass = $operations . '\\FetchData';

			return $dbClass::innerJoin($pdo, ['*'], 'user_group', 'group', ['group_id', 'id'], ['user_id', $user->getId()]);
		});

		$userRepository = new User($this->storage);
		$fichesRepository = new Fiches($this->storage);

		foreach ($result as $row) {
			$groupId = new UniqueId($row['group_id']);
			$ownerId = $row['owner_id'];
			$groupName = new GroupName($row['name']);

			if($user->getId() === $ownerId) {
				$owner = $user;
			} else {
				$owner = $userRepository->getById($ownerId);
			}

			$group = new Group($groupId, $owner, $groupName, $fichesRepository);
			$userGroup = new UserGroup($user, $group, new UserFiches($this->storage));

			$userGroupsCollection->append($userGroup);
		}
	}
}
