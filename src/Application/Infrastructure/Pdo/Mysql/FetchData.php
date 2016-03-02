<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Application\Infrastructure\Pdo\BasicFunctions;

/**
 * Class FetchData
 * @package Fiche\Application\Infrastructure\Pdo\Mysql
 */
class FetchData
{
	/**
	 * Prepare basic SELECT query with all columns and table name
	 *
	 * @param $columns
	 * @param $tableName
	 *
	 * @return string
	 */
	private static function baseQuery(array $columns, $tableName): \string
	{
		$columns = implode(', ', $columns);
		$table = DbPdoConnector::getTableNameWithPrefix($tableName);

		return "SELECT $columns FROM `$table`";
	}

	/**
	 * Fetch one record by field name
	 *
	 * @param \Pdo $pdo
	 * @param array $columns
	 * @param $tableName
	 * @param $field
	 * @param $value
	 * @return mixed|null
	 */
	public static function getByField(\Pdo $pdo, array $columns, string $tableName, string $field, string $value)
	{
		$query = self::baseQuery($columns, $tableName) . " WHERE $field='$value'";
		$stmt = $pdo->prepare($query);

		if (!($stmt->execute())) {
			return null;
		}

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public static function getRow(\Pdo $pdo, array $columns, string $tableName, array $conditions)
	{
		$query = self::baseQuery($columns, $tableName);

		$i = 0;
		foreach($conditions as $key => $value) {
			if($i === 0) {
				$query .= " WHERE ";
			} else {
				$query .= " AND ";
			}

			$query .= "$key='$value'";

			$i++;
		}

		$query .= ' LIMIT 1';

		$stmt = $pdo->prepare($query);

		if (!($stmt->execute())) {
			return null;
		}

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Fetch all records
	 *
	 * @param \PDO $pdo
	 * @param $columns
	 * @param $tableName
	 *
	 * @return array
	 */
	public static function fetchAll(\PDO $pdo, array $columns, string $tableName): array
	{
		$query = self::baseQuery($columns, $tableName);

		$stmt = $pdo->prepare($query);
		if (!($stmt->execute())) {
			return [];
		}

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}


	public static function innerJoin(\PDO $pdo, array $columns, string $tableName, string $joinTable, array $onCondition = null, array $whereCondition = null)
	{
		$joinTable = $table = DbPdoConnector::getTableNameWithPrefix($joinTable);

		$query = self::baseQuery($columns, $tableName);
		$query .= " AS t1 INNER JOIN `$joinTable` AS t2";

		if($onCondition !== null) {
			$query .= " ON t1.$onCondition[0]=t2.$onCondition[1]";
		}

		if($whereCondition !== null) {
			$query .= " WHERE t1.$whereCondition[0]=$whereCondition[1]";
		}

		$stmt = $pdo->prepare($query);

		if (!($stmt->execute())) {
			return [];
		}

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
