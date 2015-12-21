<?php

namespace Fiche\Application\Infrastructure;

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

	public function __construct($db_user, $db_pass, $db_name, $db_host, $db_type = 'mysql')
	{
		$this->pdo = new \PDO("$db_type:host=$db_host;dbname=$db_name", $db_user, $db_pass);

		$db_type = ucfirst($db_type);
		$this->operations = "Fiche\\Application\\Infrastructure\\Pdo\\$db_type";
	}

	/**
	 * Find all records for $aggregator entity type
	 *
	 * @param AggregateInterface $aggregator
	 * @param array $options
	 */
	public function fetchAll(AggregateInterface $aggregator, array $options = [])
	{
		$reflectionEntityClass = new \ReflectionClass($aggregator->getEntityClass());
		$operation = "$this->operations\\FetchData";
		$stmt = $operation::fetchAll($this->pdo, $reflectionEntityClass);

		foreach($stmt as $row) {
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
		$id = $operation::insert($this->pdo, new \ReflectionClass($entity), $entity->getValues());
		$entity->setId(intval($id));
	}

	/**
	 * Update Entity record in database
	 *
	 * @param Entity $entity
	 */
	public function update(Entity $entity)
	{

	}

	/**
	 * Delete Entity record from database
	 *
	 * @param Entity $entity
	 */
	public function delete(Entity $entity)
	{

	}
}
