$(document).ready(function () {
    // Load more movies when the user scrolls to the bottom
    let LazyLoadMovies = new LazyLoad($('#movies-content-list'), 500, loadMoreMovies);
    LazyLoadMovies.watch();

    // Load more episodes when the user scrolls to the bottom
    let LazyLoadEpisodes = new LazyLoad($('#episodes-content-list'), 500, loadMoreEpisodes);
    LazyLoadEpisodes.watch();

});