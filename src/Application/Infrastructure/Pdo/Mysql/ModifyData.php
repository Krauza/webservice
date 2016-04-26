<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

use Fiche\Application\Infrastructure\DbPdoConnector;
use Fiche\Domain\Aggregate\UserFicheStatus;

class ModifyData
{
	private static function getPlaceholders(array $fields)
	{
		return implode(', ', array_map(function() {
			return '?';
		}, $fields));
	}

	public static function execute(\PDOStatement $stmt)
	{
		if ($stmt->execute()) {
			return true;
		}

		return false;
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

		return self::execute($pdo->prepare("UPDATE `$table` SET $fields WHERE id=$id"));
	}

	public static function delete(\PDO $pdo, string $tableName, string $id)
	{
		$table = DbPdoConnector::getTableNameWithPrefix($tableName);
		return self::execute($pdo->prepare("DELETE FROM `$table` WHERE id=$id"));
	}

	public static function createConnections(\PDO $pdo, $user_id, $group_id)
	{
		$table = DbPdoConnector::getTableNameWithPrefix('user_fiche');
		$tableFiche = DbPdoConnector::getTableNameWithPrefix('fiche');

		$query = "SELECT id FROM `$tableFiche` WHERE group_id='$group_id' AND id NOT IN (SELECT fiche_id FROM `$table` WHERE user_id='$user_id') LIMIT " . UserFicheStatus::FICHES_COUNT_AT_FIRST_LEVEL;
		$fichesIds = FetchData::executeFetchAllStatement($pdo->prepare($query));

		$data = [];
		foreach($fichesIds as $ficheId) {
			$dateTime = date("Y-m-d H:i:s") . substr((string)microtime(), 1, 8);
			$id = $ficheId['id'];
			$data[] = "('$user_id', '$id', 1, '$dateTime', 0)";
		}

		$query = "INSERT INTO `$table` (user_id, fiche_id, level, last_modified, archived) VALUES " . implode(', ', $data);
		return self::execute($pdo->prepare($query));
	}
}
