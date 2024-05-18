<div class="episodes-container">
    <?php
    $episodes = ContentManager::getTVEpisodes();
    foreach ($episodes as $episode) {
        loadTemplate('episode_card', ['episode' => $episode]);
    }
    ?>
</div>