<?php

$config = require_once(__DIR__ . '/../config/config.php');
$db_settings = $config['database']['mysql'];

$mysql_host = $db_settings['db_host'];
$mysql_database = $db_settings['db_name'] . '_' . $config['environment'];
$mysql_user = $db_settings['db_user'];
$mysql_password = $db_settings['db_pass'];

$message = "";

try {
    $db = new PDO("mysql:host=$mysql_host", $mysql_user, $mysql_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if($config['environment'] === 'test') {
        $db->exec("DROP DATABASE IF EXISTS $mysql_database");
    }

    $db->query("CREATE DATABASE IF NOT EXISTS $mysql_database DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci");
    $db->query("use $mysql_database");

    $query = file_get_contents(__DIR__ . "/db_schema.sql");
    $stmt = $db->prepare($query);

    if ($stmt->execute()) {
        fwrite(STDOUT, 'Database created');
    } else {
        fwrite(STDERR, 'Error during creating database schema');
    }
} catch(Exception $exception) {
    fwrite(STDERR, $exception);
}

$db = null;
