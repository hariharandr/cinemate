<?php
require_once '../../src/load.php';
header('Content-Type: application/json');

$search_term = isset($_GET['query']) ? $_GET['query'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'all';  // Default is 'all'
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// based on the type parameter, the search function will return the results for movies, tv episodes, or all types of content
$results = ContentManager::searchMoview($search_term, $type, $page, $limit);

// based on the type loadtemplate loads either movies, episodes, or casts
if ($type === 'movies') {
    loadTemplate('/movies/movies', ['movies' => $results]);
} elseif ($type === 'episodes') {
    loadTemplate('/episodes/episodes', ['episodes' => $results]);
} elseif ($type === 'casts') {
    loadTemplate('/cast/casts', ['casts' => $results]);
} else {
    // if all load based on each type and send the results
    foreach ($results as $type => $result) {
        if ($type === 'movies') {
            loadTemplate('/movies/movies', ['movies' => $result]);
        } elseif ($type === 'episodes') {
            loadTemplate('/episodes/episodes', ['episodes' => $result]);
        } elseif ($type === 'casts') {
            loadTemplate('/cast/casts', ['casts' => $result]);
        }
    }
}
