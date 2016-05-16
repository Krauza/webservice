<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Application\Infrastructure\UniqueId;
use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group as GroupEntity;
use Fiche\Domain\Factory\FicheFactory;
use Fiche\Domain\Repository\FichesRepository;
use Fiche\Domain\Service\FichesCollection;

class Fiches implements PdoRepository, FichesRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage) {
		$this->storage = $storage;
	}

	public function getById($id): Fiche
	{
		$data =  $this->storage->query(function($pdo, $operations) use ($id) {
			$dbClass = $operations . '\\FetchData';

			return $dbClass::getRow($pdo, ['*'], 'fiche', [
				'id' => $id
			]);
		});


		$id = new UniqueId($data['id']);
		$groupRepository = new Group($this->storage);
		$group = $groupRepository->getById($data['group_id']);
		return FicheFactory::create($id, $group, $data['word'], $data['explain_word']);
	}

	public function getMultipleByIds(array $ids)
	{
		return $this->storage->query(function($pdo, $operations) use ($ids) {
			$dbClass = $operations . '\\FetchData';

			return $dbClass::fetchAll($pdo, ['*'], 'fiche', null, [
				'id' => $ids
			]);
		});
	}

	public function getForGroup(GroupEntity $group, FichesCollection $fichesCollection)
	{
		// TODO: Implement getForGroup() method.
	}

	public function insert(Fiche $fiche)
	{
		return $this->storage->query(function($pdo, $operations) use ($fiche) {
			$dbClass = $operations . '\\ModifyData';

			$data = [
				'id' => $fiche->getId(),
				'group_id' => $fiche->getGroup()->getId(),
				'word' => $fiche->getWord(),
				'explain_word' => $fiche->getExplainWord()
			];

			return $dbClass::insert($pdo, 'fiche', $data);
		});
	}
}
