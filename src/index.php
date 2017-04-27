<?php

require __DIR__ . '/../vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Schema;
use Krauza\Infrastructure\Api\TypeRegistry;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

use Krauza\Infrastructure\Policy\UniqueId;

use Pimple\Container;

$container = new Container();
$container['database_connection'] = function () {
    $config = new Configuration();
    $connectionParams = [
        'dbname' => 'krauza',
        'user' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ];

    return DriverManager::getConnection($connectionParams, $config);
};
$container['id_policy'] = function () {
    return new UniqueId();
};
$container['current_user'] = function () {
    return new \Krauza\Core\Entity\User(new \Krauza\Core\ValueObject\UserName('test'));
};

if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    $rawBody = file_get_contents('php://input');
    $data = json_decode($rawBody ?: '', true);
} else {
    $data = $_POST;
}

$requestString = isset($data['query']) ? $data['query'] : null;
$operationName = isset($data['operation']) ? $data['operation'] : null;
$variableValues = isset($data['variables']) ? $data['variables'] : null;

try {
    $schema = new Schema([
        'query' => TypeRegistry::getQueryType(),
        'mutation' => TypeRegistry::getMutationType()
    ]);
    $result = GraphQL::execute(
        $schema,
        $requestString,
        null,
        $container,
        $variableValues,
        $operationName
    );
} catch (Exception $exception) {
    $result = [
        'errors' => [
            ['message' => $exception->getMessage()]
        ]
    ];
}

header('Content-Type: application/json');
echo json_encode($result);
