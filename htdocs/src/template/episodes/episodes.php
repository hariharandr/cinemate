<div id="episodes-container" class="content-container" data-attribute="episodes">
    <h2 class="content-title">TV Episodes</h2>
    <div id="temp-episodes-list" class="temp-content-list"></div>

    <div id="episodes-content-list" class="episodes-list content-list" data-type="episodes" data-page="1">
        <?php
        $episodes = ContentManager::getEpisodes();
        foreach ($episodes as $episode) : ?>
            <?php loadTemplate('/episodes/episode_cards/episode', ['episode' => $episode]); ?>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <!-- Pagination can be implemented here -->
        <button class="btn btn-primary" onclick="loadMoreEpisodes()">More Episodes</button>
    </div>
</div>