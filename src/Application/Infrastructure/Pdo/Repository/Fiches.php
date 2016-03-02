<?php

namespace Fiche\Application\Infrastructure\Pdo\Repository;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group as GroupEntity;
use Fiche\Domain\Repository\FichesRepository;

class Fiches implements PdoRepository, FichesRepository
{
	private $storage;

	public function __construct(DbPdoConnector $storage) {
		$this->storage = $storage;
	}

	public function getForGroup(GroupEntity $group)
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
