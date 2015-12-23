<?php

namespace Fiche\Application\Infrastructure\Pdo\Mysql;

use Fiche\Domain\Service\Entity;

class BasicFunctions
{
	public static function getColumns($classFields)
	{
		$fields = [];
		foreach($classFields as $type => $field) {
			if(!self::isBasicType($type) && self::isImplementAggregateInterface($type)) {
				continue;
			}

			array_push($fields, $field);
		}

		return implode(', ', $fields);
	}

	public static function isBasicType($type)
	{
		$types = ['string', 'int', 'float'];

		if(in_array($type, $types)) {
			return true;
		}

		return false;
	}

	private static function isImplementAggregateInterface($type)
	{
		$implements = class_implements($type);

		if(is_array($implements)) {
			return in_array('Fiche\Domain\Service\AggregateInterface', $implements);
		}

		return false;
	}

	public static function bindParams(\PDOStatement $stmt, array $values)
	{
		$i = 1;
		foreach($values as $value) {
			$stmt->bindParam($i, $value);
			$i++;
		}
	}

	public static function getFields(array $values): string
	{
		$fields = array_keys($values);
		return implode(',', $fields);
	}

	public static function setPlaceholders(array $values): string
	{
		return implode(', ', array_fill(0, count($values), '?'));
	}

	public static function getTableName(Entity $entity)
	{
		$reflection = new \ReflectionClass($entity);
		return strtolower($reflection->getShortName());
	}

	public static function getFieldsWithPlaceholders(array $values): string
	{
		return implode(', ', array_map(
			function($field) {
				return $field . '=?';
			},
			array_keys($values))
		);
	}
}
