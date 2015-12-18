<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

class ModifyData
{
	public static function insert(\PDO $pdo, \ReflectionClass $reflection, array $values)
	{
		$table = strtolower($reflection->getShortName());
		$fields = BasicFunctions::getFields($values);
		$placeholders = BasicFunctions::setPlaceholders($values);

		$stmt = $pdo->prepare("INSERT INTO `$table` ($fields) VALUES ($placeholders)");
		if($stmt->execute(array_values($values))) {
			return $pdo->lastInsertId();
		}

		return null;
	}
}
