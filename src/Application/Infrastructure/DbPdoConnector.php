<?php

namespace Fiche\Application\Infrastructure;

use Fiche\Domain\Service\AggregateInterface;
use Fiche\Domain\Service\Entity;
use Fiche\Domain\Service\StorageInterface;

class DbPdoConnector implements StorageInterface
{
	private $pdo;

	public function __construct($db_user, $db_pass, $db_name, $db_host, $db_type = 'mysql')
	{
		$this->pdo = new \PDO("$db_type:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	}

	public function fetchAll(AggregateInterface $aggregator, $options = [])
	{
		$entityClass = $aggregator->getEntityClass();
		$classFields = $entityClass::getFieldsNames();
		$this->setDataToAggregator($aggregator, $entityClass, $classFields);
	}

	private function getTableName($className)
	{
		$path = explode('\\', $className);
		return strtolower(array_pop($path));
	}

	private function getColumns($classFields)
	{
		$fields = [];
		foreach($classFields as $type => $field) {
			if(!$this->isBasicType($type) && $this->isImplementAggregateInterface($type)) {
				continue;
			}

			array_push($fields, $field);
		}

		return implode(', ', $fields);
	}

	private function isBasicType($type)
	{
		$types = ['string', 'int', 'float'];

		if(in_array($type, $types)) {
			return true;
		}

		return false;
	}

	private function isImplementAggregateInterface($type)
	{
		$implements = class_implements($type);

		if(is_array($implements)) {
			return in_array('AggregateInterface', $implements);
		}

		return false;
	}

	private function selectQuery($table, $columns)
	{
		if(!($stmt = $this->pdo->query("SELECT $columns FROM $table"))) {
			return [];
		}

		return $stmt;
	}

	private function setDataToAggregator(AggregateInterface $aggregator, $entityClass, $classFields)
	{
		$reflectionEntityClass = new \ReflectionClass($entityClass);

		$stmt = $this->selectQuery(
			$this->getTableName($entityClass),
			$this->getColumns($classFields)
		);

		foreach($stmt as $row) {
			$aggregator->append($reflectionEntityClass->newInstanceArgs(array_values($row)));
		}
	}

	public function insert(Entity $entity)
	{
		$values = $entity->getValues();
		$tableName = $this->getTableName($entity);

		$stmt = $this->pdo->prepare("INSERT INTO $tableName VALUES ()");
	}

	public function update(Entity $entity)
	{

	}

	public function delete(Entity $entity)
	{

	}
}
