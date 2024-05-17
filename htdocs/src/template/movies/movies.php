<div class="movies_container" id="moviesContainer">
    <?php
    foreach ($movies as $movie) {
        if ($movie['titleType'] === 'movie') {
            if (!empty($movie['primaryTitle']) && trim($movie['primaryTitle']) != '')
                loadTemplate('/movies/movie_cards/movie',  ['movie' => $movie]);
        }
    } ?>
</div>