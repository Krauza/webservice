<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Aggregate\UserFicheStatus;
use Fiche\Domain\Aggregate\UserGroup;
use Fiche\Domain\Factory\FicheFactory;
use Fiche\Domain\Repository\UserFichesRepository;
use Fiche\Domain\Service\UserFichesCollection;
use Fiche\Domain\Entity\User as UserEntity;

class UserFiches implements PdoRepository, UserFichesRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage)
	{
		$this->storage = $storage;
	}

	public function fetchAllActiveForUserGroup(UserGroup $userGroup, UserFichesCollection $userFichesCollection)
	{
		$result = $this->storage->query(function($pdo, $operations) use ($userGroup) {
			$dbClass = $operations . '\\FetchData';

			return $dbClass::fetchAll($pdo, ['*'], 'user_fiche', [
				'archived' => false,
				'user_id' => $userGroup->getUser()->getId(),
				'group_id' => $userGroup->getGroup()->getId()
			]);
		});

		$fichesRepository = new Fiches($this->storage);
		$fiches = $fichesRepository->getMultipleByIds(array_column($result, 'fiche_id'));

		foreach($fiches as $fiche) {
			$ficheStatus = $result[array_search($fiche['id'], array_column($result, 'fiche_id'))];

			$ficheObj = FicheFactory::create(
				new UniqueId($fiche['id']),
				$userGroup->getGroup(),
				$fiche['word'],
				$fiche['explain_word']
			);

			$ficheStatusObj = new UserFicheStatus(
				$ficheObj,
				$userGroup,
				$ficheStatus['level'],
				new \DateTime($ficheStatus['last_modified'])
			);

			$userFichesCollection->append($ficheStatusObj);
		}
	}

	public function update(UserFicheStatus $userFicheStatus)
	{
		return $this->storage->query(function($pdo, $operations) use ($userFicheStatus) {
			$dbClass = $operations . '\\ModifyData';

			return $dbClass::update($pdo, 'user_fiche', [
				'level' => $userFicheStatus->getLevel(),
				'last_modified' => $userFicheStatus->getPosition()->format('Y-m-d H:i:s.u'),
				'archived' => $userFicheStatus->isArchived()
			], [
				'user_id' => $userFicheStatus->getUserGroup()->getUser()->getId(),
				'fiche_id' => $userFicheStatus->getFiche()->getId()
			]);
		});
	}

	public function createConnections(UserGroup $userGroup, UserFichesCollection $userFichesCollection)
	{
		$result = $this->storage->query(function($pdo, $operations) use ($userGroup) {
			$dbClass = $operations . '\\ModifyData';

			return $dbClass::createConnections($pdo, $userGroup->getUser()->getId(), $userGroup->getGroup()->getId());
		});

		if($result) {
			$this->fetchAllActiveForUserGroup($userGroup, $userFichesCollection);
		}
	}

	public function fetchByFicheForUser(UserEntity $user, Fiche $fiche): UserFicheStatus
	{
		$result = $this->storage->query(function($pdo, $operations) use ($user, $fiche) {
			$dbClass = $operations . '\\FetchData';

			return $dbClass::getRow($pdo, ['*'], 'user_fiche', [
				'user_id' => $user->getId(),
				'fiche_id' => $fiche->getId()
			]);
		});

		$userGroup = new UserGroup($user, $fiche->getGroup(), $this);

		return new UserFicheStatus(
			$fiche,
			$userGroup,
			$result['level'],
			new \DateTime($result['last_modified']),
			$result['archived']
		);
	}
}
