<?php

namespace Fiche\Application\Infrastructure;

use Fiche\Application\Exceptions\RecordNotExists;
use Fiche\Application\Infrastructure\Pdo\BasicFunctions;


/**
 * Connects to database via PDO driver
 * Mostly it is universal class and it was prepared for easy replace db type
 * Default database type is MySQL
 *
 * Class DbPdoConnector
 * @package Fiche\Application\Infrastructure
 */
class DbPdoConnector
{
	const TABLE_PREFIX = 'fiche';

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

	public function query(\Closure $closure)
	{
		return $closure($this->pdo, $this->operations);
	}

	public static function getTableNameWithPrefix($tableName)
	{
		return self::TABLE_PREFIX . '_' . $tableName;
	}
}
