<?php

namespace Fiche\Application\Infrastructure;

use Fiche\Domain\Service\AggregateInterface;
use Fiche\Domain\Service\StorageInterface;

class DbPdoConnector implements StorageInterface
{
	private $pdo;

	public function __construct($db_user, $db_pass, $db_name, $db_host, $db_type = 'mysql')
	{
		$this->pdo = new \PDO("$db_type:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	}

	public function fetchAll(AggregateInterface $aggregator)
	{
		$entityClass = $aggregator->getEntityClass();
		$classFields = $entityClass::getFieldsNames();
//		$stmt = $this->pdo->query('SELECT id FROM groups');
//
//		$stmt->closeCursor();
	}

	private function getClassName($className) {
		$path = explode('\\', $className);
		return array_pop($path);
	}
}
