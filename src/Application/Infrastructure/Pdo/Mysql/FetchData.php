<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

class FetchData
{
	static public function fetchAll(\PDO $pdo, \ReflectionClass $reflection)
	{
		$entity = $reflection->getName();
		$columns = BasicFunctions::getColumns($entity::getFieldsNames());
		$table = strtolower($reflection->getShortName());

		$stmt = $pdo->prepare("SELECT $columns FROM `$table`");

		if(!($stmt->execute())) {
			return [];
		}

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
}
