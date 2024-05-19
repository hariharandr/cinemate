<?php
require_once '../../src/load.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

// based on the type parameter, the search function will return the results for movies, tv episodes, or all types of content
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    if ($type === 'episodes') {
        $type = 'Episodes';
    } else if ($type === 'movies') {
        $type = 'Movies';
    } else if ($type === 'casts') {
        $type = 'Casts';
    }

    $callback = 'ContentManager::get' . $type;
    $results = $callback($page, $limit);
    if ($type === 'Movies') {
        foreach ($results as $movie) {
            loadTemplate('/movies/movie_cards/movie', ['movie' => $movie]);
        }
    } elseif ($type === 'Episodes') {
        foreach ($results as $episode) {
            loadTemplate('/episodes/episode_cards/episode', ['episode' => $episode]);
        }
    }
    // } elseif ($type === 'casts') {
    //     foreach ($results as $cast) {

    //         loadTemplate('/cast/cast_cards/cast', ['cast' => $results]);
    //     }
    // }
} else {
    // throw error if type is not set
    echo json_encode(['error' => 'Type is not set']);
}
