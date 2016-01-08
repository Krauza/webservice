<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

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
	 * @param \ReflectionClass $reflection
	 * @return string
	 */
	private static function baseQuery(\ReflectionClass $reflection): \string
	{
		$className = $reflection->getName();
		$columns = BasicFunctions::getColumns($className::getFieldsNames());
		$table = "fiche_" . strtolower($reflection->getShortName());

		return "SELECT $columns FROM `$table`";
	}

	/**
	 * Fetch one record by field name
	 *
	 * @param \Pdo $pdo
	 * @param \ReflectionClass $reflectionClass
	 * @param string $field
	 * @param string $value
	 * @return mixed|null
	 */
	public static function getByField(\Pdo $pdo, \ReflectionClass $reflectionClass, \string $field, \string $value)
	{
		$query = self::baseQuery($reflectionClass) . " WHERE $field='$value'";
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
	 * @param \ReflectionClass $reflection
	 * @param array $options
	 * @return array
	 */
	public static function fetchAll(\PDO $pdo, \ReflectionClass $reflection, array $options = []): array
	{
		$stmt = $pdo->prepare(self::baseQuery($reflection) . self::prepareQueryFromOptions($options));
		if (!($stmt->execute())) {
			return [];
		}

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	private static function prepareQueryFromOptions(array $options = [])
	{
		$query = '';

		if (isset($options['where'])) {
			$key = array_keys($options['where'])[0];
			$value = array_values($options['where'])[0];

			$query .= " WHERE $key=$value";
		}

		return $query;
	}
}
