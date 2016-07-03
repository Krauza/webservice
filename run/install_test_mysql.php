<?php

require('connect_mysql.php');

$mysqlConnector = new MysqlConnector();
$mysqlConnector->dropDatabase();
$mysqlConnector->createDatabase();
$mysqlConnector->useDatabase();
$mysqlConnector->loadDatabaseSchema();
$mysqlConnector->loadTestFixtures();
$mysqlConnector->deleteDatabaseConnection();
