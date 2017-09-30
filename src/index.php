<?php

require __DIR__ . '/../vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\Error;
use Krauza\Infrastructure\Api\Type\QueryType;
use Krauza\Infrastructure\Api\Type\MutationType;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

use Krauza\Infrastructure\Policy\UniqueId;

use Pimple\Container;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
    $user = new \Krauza\Core\Entity\User(new \Krauza\Core\ValueObject\UserName('test'));
    $user->setId(new \Krauza\Core\ValueObject\EntityId('test'));

    return $user;
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
    $status = 200;
    $schema = new Schema([
        'query' => QueryType::getInstance(),
        'mutation' => MutationType::getInstance()
    ]);
    $result = GraphQL::executeQuery(
        $schema,
        $requestString,
        null,
        $container,
        $variableValues,
        $operationName
    )->setErrorFormatter(function (Error $error) {
        return [
            'message' => $error->message
        ];
    })->toArray();
} catch (Exception $exception) {
    $status = 500;
    $result = [
        'errors' => [
            ['message' => $exception->getMessage()]
        ]
    ];
}

header('Content-Type: application/json', $status);
echo json_encode($result);
