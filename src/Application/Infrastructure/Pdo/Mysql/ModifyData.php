<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

use Fiche\Domain\Service\Entity;
use Fiche\Application\Infrastructure\Pdo\BasicFunctions;

class ModifyData
{
	public static function insert(\PDO $pdo, Entity $entity)
	{
		$table = BasicFunctions::getTableName($entity);
		$fields = BasicFunctions::getFields($entity->getValues());
		$placeholders = BasicFunctions::setPlaceholders($entity->getValues());

		$stmt = $pdo->prepare("INSERT INTO `$table` ($fields) VALUES ($placeholders)");
		if ($stmt->execute(array_values($entity->getValues()))) {
			return $pdo->lastInsertId();
		}

		return null;
	}

	public static function update(\PDO $pdo, Entity $entity)
	{
		$table = BasicFunctions::getTableName($entity);
		$placeholders = BasicFunctions::getFieldsWithPlaceholders($entity->getValues());
		$id = $entity->getId();

		$stmt = $pdo->prepare("UPDATE `$table` SET $placeholders WHERE id=$id");
		if ($stmt->execute(array_values($entity->getValues()))) {
			return true;
		}

		return false;
	}

	public static function delete(\PDO $pdo, Entity $entity)
	{
		$table = BasicFunctions::getTableName($entity);
		$id = $entity->getId();

		$stmt = $pdo->prepare("DELETE FROM `$table` WHERE id=$id");
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
