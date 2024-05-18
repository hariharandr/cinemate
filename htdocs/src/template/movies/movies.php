<div id="movies-container" class="content-container">
    <h2 class="content-title">Movies</h2>
    <div class="movies-list content-list">
        <?php
        $movies = ContentManager::getMovies();
        foreach ($movies as $movie) : ?>
            <?php loadTemplate('/movies/movie_cards/movie', ['movie' => $movie]); ?>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <button class="btn btn-primary" onclick="loadMoreMovies()">More Movies</button>
    </div>

</div>