<?php

namespace Fiche\Application\Infrastructure;

use Fiche\Domain\Service\StorageInterface;

class DbPdoConnector implements StorageInterface
{
	private $pdo;

	public function __construct($db_user, $db_pass, $db_name, $db_host, $db_type = 'mysql')
	{
		$this->pdo = new \PDO("$db_type:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	}

	public function fetchAll($command, $arrayObject)
	{

	}
}
