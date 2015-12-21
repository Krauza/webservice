<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

/**
 * Class FetchData
 * @package Fiche\Application\Infrastructure\Pdo\Mysql
 */
class FetchData
{
	/**
	 * Prepare basic SELECT query with all columns and table name
	 *
	 * @param \ReflectionClass $reflection
	 * @return string
	 */
	static private function baseQuery(\ReflectionClass $reflection): \string
	{
		$className = $reflection->getName();
		$columns = BasicFunctions::getColumns($className::getFieldsNames());
		$table = strtolower($reflection->getShortName());

		return "SELECT $columns FROM `$table`";
	}

	/**
	 * Fetch one record by id
	 *
	 * @param \Pdo $pdo
	 * @param \ReflectionClass $reflection
	 * @param $id
	 * @return mixed|null
	 */
	static public function getById(\Pdo $pdo, \ReflectionClass $reflection, $id)
	{
		$query = self::baseQuery($reflection) . " WHERE id=$id";
		$stmt = $pdo->prepare($query);

		if(!($stmt->execute())) {
			return null;
		}

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Fetch all records
	 *
	 * @param \PDO $pdo
	 * @param \ReflectionClass $reflection
	 * @return array
	 */
	static public function fetchAll(\PDO $pdo, \ReflectionClass $reflection)
	{
		$stmt = $pdo->prepare(self::baseQuery($reflection));
		if(!($stmt->execute())) {
			return [];
		}

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
