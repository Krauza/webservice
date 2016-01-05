<?php

namespace Fiche\Application\Infrastructure;

use Fiche\Application\Exceptions\RecordNotExists;
use Fiche\Application\Infrastructure\Pdo\BasicFunctions;
use Fiche\Domain\Service\AggregateInterface;
use Fiche\Domain\Service\Entity;
use Fiche\Domain\Service\StorageInterface;

/**
 * Connects to database via PDO driver
 * Mostly it is universal class and it was prepared for easy replace db type
 * Default database type is MySQL
 *
 * Class DbPdoConnector
 * @package Fiche\Application\Infrastructure
 */
class DbPdoConnector implements StorageInterface
{
	/**
	 * Save correct connection with database via PDO interface
	 * @var \PDO
	 */
	private $pdo;

	/**
	 * Contain namespace to correct database type operations
	 * @var string
	 */
	private $operations;

	public function __construct($dbUser, $dbPass, $dbName, $dbHost, $dbType = 'mysql')
	{
		$this->pdo = new \PDO("$dbType:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

		$dbType = ucfirst($dbType);
		$this->operations = "Fiche\\Application\\Infrastructure\\Pdo\\$dbType";
	}

	/**
	 * Get record by id
	 *
	 * @param string $className
	 * @param int $id
	 * @return object
	 * @throws RecordNotExists
	 */
	public function getById(\string $className, \int $id)
	{
		$reflection = new \ReflectionClass($className);
		$operation = "$this->operations\\FetchData";
		$result = $operation::getById($this->pdo, $reflection, $id);
		if(empty($result)) {
			throw new RecordNotExists;
		}

		$result = $this->convertRawIdsToObjects($className, $result);
		return $reflection->newInstanceArgs(array_values($result));
	}

	/**
	 * Find all records for $aggregator entity type
	 *
	 * @param AggregateInterface $aggregator
	 * @param array $options
	 */
	public function fetchAll(AggregateInterface $aggregator, array $options = [])
	{
		$entityClass = $aggregator->getEntityClass();
		$reflectionEntityClass = new \ReflectionClass($entityClass);
		$operation = "$this->operations\\FetchData";
		$stmt = $operation::fetchAll($this->pdo, $reflectionEntityClass, $options);

		foreach($stmt as $row) {
			$row = $this->convertRawIdsToObjects($entityClass, $row);
			$aggregator->append($reflectionEntityClass->newInstanceArgs(array_values($row)));
		}
	}

	/**
	 * Insert new Entity record to database
	 *
	 * @param Entity $entity
	 */
	public function insert(Entity $entity)
	{
		$operation = "$this->operations\\ModifyData";
		$id = $operation::insert($this->pdo, $entity);
		$entity->setId(intval($id));
	}

	/**
	 * Update Entity record in database
	 *
	 * @param Entity $entity
	 */
	public function update(Entity $entity)
	{
		$operation = "$this->operations\\ModifyData";
		return $operation::update($this->pdo, $entity);
	}

	/**
	 * Delete Entity record from database
	 *
	 * @param Entity $entity
	 */
	public function delete(Entity $entity)
	{
		$operation = "$this->operations\\ModifyData";
		return $operation::delete($this->pdo, $entity);
	}

	private function convertRawIdsToObjects($entityClass, $row)
	{
		foreach($entityClass::getFieldsNames() as $key => $value) {
			if(!BasicFunctions::isBasicType($value)) {
				$entity = new \ReflectionClass($value);

				if($entity->isSubclassOf(Entity::class)) {
					$row[$key] = $this->getById($value, $row[$key]);
				}
			}
		}

		return $row;
	}
}
