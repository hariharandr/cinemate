<div id="cast-container" class="content-container">
    <h2 class="content-title">Cast & Crew</h2>
    <div class="cast-list content-list">
        <?php
        $cast = ContentManager::getCast();
        foreach ($cast as $cast_member) : ?>
            <?php loadTemplate('/cast/cast_cards/cast', ['cast' => $cast_member]);
            ?>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <button class="btn btn-primary" onclick="loadMoreCast()">More Cast & Crew</button>
    </div>
</div>