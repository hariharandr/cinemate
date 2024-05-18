<div id="movies-container" class="content-container" data-attribute="movies">
    <h2 class="content-title">Movies</h2>
    <div id="temp-movies-list" class="temp-content-list"></div>
    <div id="movies-content-list" class=" content-list">
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