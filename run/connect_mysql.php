<?php

class MysqlConnector
{
    private $config;
    private $mysql_host;
    private $mysql_password;
    private $mysql_database;
    private $mysql_user;
    private $db;

    public function __construct()
    {
        $this->config = require(__DIR__ . '/../config/config.php');
        $this->setDatabaseCredentials();
        $this->createDatabaseConnection();
    }

    private function setDatabaseCredentials()
    {
        $db_settings = $this->config['database']['mysql'];

        $this->mysql_host = $db_settings['db_host'];
        $this->mysql_database = $db_settings['db_name'];
        $this->mysql_user = $db_settings['db_user'];
        $this->mysql_password = $db_settings['db_pass'];
    }

    private function createDatabaseConnection()
    {
        try {
            $this->db = new PDO("mysql:host=$this->mysql_host", $this->mysql_user, $this->mysql_password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            $this->notifyError($e);
        }
    }

    private function notifyError($error)
    {
        fwrite(STDERR, print_r($error, TRUE));
    }

    public function deleteDatabaseConnection()
    {
        $this->db = null;
    }

    public function loadDatabaseSchema()
    {
        $this->executeQuery(file_get_contents(__DIR__ . "/db_schema.sql"));
    }

    public function loadTestFixtures()
    {
        $this->executeQuery(file_get_contents(__DIR__ . "/example_mysql_data.sql"));
    }

    public function executeQuery($query)
    {
        try {
            $stmt = $this->db->prepare($query);
            if (!$stmt->execute()) {
                $this->notifyError('Error during creating database schema');
                return false;
            }
        } catch (Exception $e) {
            $this->notifyError($e);
        }

        return true;
    }

    public function isTestEnv()
    {
        return $this->config['environment'] === 'test';
    }

    public function dropDatabase()
    {
        $this->db->exec("DROP DATABASE IF EXISTS $this->mysql_database");
    }

    public function createDatabase()
    {
        $this->db->query("CREATE DATABASE IF NOT EXISTS $this->mysql_database DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci");
    }

    public function useDatabase()
    {
        $this->db->query("use $this->mysql_database");
    }
}
