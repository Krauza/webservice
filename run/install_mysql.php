<?php

$config = require_once(__DIR__ . '/../config/config.php');
$db_settings = $config['database']['mysql'];

$mysql_host = $db_settings['db_host'];
$mysql_database = $db_settings['db_name'];
$mysql_user = $db_settings['db_user'];
$mysql_password = $db_settings['db_pass'];

$db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
$query = file_get_contents(__DIR__ . "/db_schema.sql");
$stmt = $db->prepare($query);

if ($stmt->execute()) {
    unlink(__FILE__);
}
