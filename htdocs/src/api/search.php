<?php
require_once '../../src/load.php';

$search_term = isset($_GET['query']) ? $_GET['query'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'all';  // Default is 'all'
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// based on the type parameter, the search function will return the results for movies, tv episodes, or all types of content
$results = ContentManager::searchMovie($search_term, $type, $page, $limit);

// based on the type loadtemplate loads either movies, episodes, or casts
if ($type === 'movies') {
    foreach ($results as $movie) {
        loadTemplate('/movies/movie_cards/movie', ['movie' => $movie]);
    }
} elseif ($type === 'episodes') {
    loadTemplate('/episodes/episodes', ['episode' => $results]);
} elseif ($type === 'casts') {
    loadTemplate('/cast/cast_cards/cast', ['cast' => $results]);
} else {
    // if all load based on each type and send the results
    foreach ($results as $type => $result) {
        if ($type === 'movies') {
            loadTemplate('/movies/movie_cards/movie', ['movies' => $result]);
        } elseif ($type === 'episodes') {
            loadTemplate('/episodes/episode_cards/episode', ['episode' => $result]);
        } elseif ($type === 'casts') {
            loadTemplate('/casts/cast_cards/cast', ['cast' => $result]);
        }
    }
}
