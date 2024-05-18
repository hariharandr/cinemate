<div id="casts-container" class="content-container" data-attribute="casts">
    <h2 class="content-title">Cast & Crew</h2>
    <div id="temp-cast-list" class="temp-content-list"></div>
    <div class="cast-list content-list">
        <?php
        // $cast = ContentManager::getCast();
        // foreach ($cast as $cast_member) {
        //     loadTemplate('/cast/cast_cards/cast', ['cast' => $cast_member]);
        // }
        ?>
    </div>
    <div class="pagination">
        <button class="btn btn-primary" onclick="loadMoreCast()">More Cast & Crew</button>
    </div>
</div>