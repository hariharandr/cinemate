<?php
require_once '../../src/load.php'; // Make sure this path is correct to include autoload and any other necessary setup

header('Content-Type: application/json');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        handleGetRequest();
        break;
        // Implement other methods as needed
    default:
        echo json_encode(['message' => 'Method not supported']);
        http_response_code(405);
}

function handleGetRequest()
{
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10; // Default to 10 items
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $skip = ($page - 1) * $limit;

    try {
        $collection = Database::getConnection()->selectCollection('title_basics');
        $options = [
            'limit' => $limit,
            'skip' => $skip
        ];
        $cursor = $collection->find([], $options);
        $data = $cursor->toArray();
        echo json_encode($data);
    } catch (MongoDB\Driver\Exception\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
