<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

use Fiche\Application\Infrastructure\DbPdoConnector;

class ModifyData
{
	private static function getPlaceholders(array $fields)
	{
		return implode(', ', array_map(function() {
			return '?';
		}, $fields));
	}

	public static function insert(\PDO $pdo, string $tableName, array $data)
	{
		$table = DbPdoConnector::getTableNameWithPrefix($tableName);
		$fields = array_keys($data);
		$placeholders = self::getPlaceholders($fields);

		$fields = implode(', ', array_keys($data));

		$stmt = $pdo->prepare("INSERT INTO `$table` ($fields) VALUES ($placeholders)");
		if ($stmt->execute(array_values($data))) {
			return true;
		}

		return null;
	}

	public static function update(\PDO $pdo, string $tableName, array $data, string $id)
	{
		$table = DbPdoConnector::getTableNameWithPrefix($tableName);
		$fields = array_map(function($field, $value) {
			return "$field='$value'";
		}, array_keys($data), array_values($data));
		$fields = implode(', ', $fields);

		$stmt = $pdo->prepare("UPDATE `$table` SET $fields WHERE id=$id");
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	public static function delete(\PDO $pdo, string $tableName, string $id)
	{
		$table = DbPdoConnector::getTableNameWithPrefix($tableName);

		$stmt = $pdo->prepare("DELETE FROM `$table` WHERE id=$id");
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
