<?php

require __DIR__ . '/../vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Schema;
use Krauza\Infrastructure\Api\TypeRegistry;

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
    // Define your schema:
    $schema = new Schema([
        'query' => TypeRegistry::getQueryType(),
        'mutation' => TypeRegistry::getMutationType()
    ]);
    $result = GraphQL::execute(
        $schema,
        $requestString,
        /* $rootValue */ null,
        /* $context */ null, // A custom context that can be used to pass current User object etc to all resolvers.
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
