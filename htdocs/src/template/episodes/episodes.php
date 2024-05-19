<div id="episodes-container" class="content-container" data-attribute="episodes">
    <h2 class="content-title"><a href="#" class="text-white me-2"><i class="fas fa-tv" aria-hidden="true"></i></a> TV Episodes</h2>
    <div id="temp-episodes-list" class="temp-content-list"></div>

    <div id="episodes-content-list" class="episodes-list content-list" data-type="episodes" data-page="1">
        <?php
        $episodes = ContentManager::getEpisodes();
        foreach ($episodes as $episode) : ?>
            <?php loadTemplate('/episodes/episode_cards/episode', ['episode' => $episode]); ?>
        <?php endforeach; ?>
    </div>
    <div class="pagination" id="episodes-pagination">
        <!-- Pagination can be implemented here -->
        <button class="btn btn-primary" onclick="loadMoreEpisodes()">More Episodes</button>
    </div>
</div>