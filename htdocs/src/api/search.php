<?php
require_once '../../src/load.php';

// Get the search term from the query parameter
$search_term = isset($_GET['query']) ? $_GET['query'] : '';

// Fetch page number if set, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Fetch limit if set, default to 10
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// Call the search function from the Movies class
$results = ContentManager::searchMoview($search_term, $limit, $page);

// Set header to application/json for proper client-side handling
header('Content-Type: application/json');

// Output the results as JSON
if (isset($results['error'])) {
    http_response_code(400);
}
echo json_encode($results);
