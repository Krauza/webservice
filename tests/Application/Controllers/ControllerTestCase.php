<?php

declare(strict_types=1);
require(__DIR__ . '/../../../run/connect_mysql.php');

use Silex\WebTestCase;
use Dotenv\Dotenv;

abstract class ControllerTestCase extends WebTestCase
{
    private $mysqlConnector;
    protected $client;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $config = require(__DIR__ . '/../../../config/config.php');

        if ($config['environment'] === 'dev') {
            $dotenv = new Dotenv(__DIR__ . '/../../../');
            $dotenv->load();
        }

        $this->mysqlConnector = new MysqlConnector();
        $this->mysqlConnector->dropDatabase();
        $this->mysqlConnector->createDatabase();
    }

    public function createApplication()
    {
        $this->mysqlConnector->useDatabase();
        $this->mysqlConnector->loadDatabaseSchema();
        $this->mysqlConnector->loadTestFixtures();

        $app = require __DIR__.'/../../../public/app.php';
        $app['session.test'] = true;
        $app['session.storage.handler'] = null;

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createClient();
        $this->client->followRedirects(true);
    }

    public function loginToPage($email = 'email', $password = 'password')
    {
        $crawler = $this->client->request('GET', '/auth/login');

        $form = $crawler->selectButton('Login')->form();
        $form['email'] = $email;
        $form['password'] = $password;

        return $this->client->submit($form);
    }
}
