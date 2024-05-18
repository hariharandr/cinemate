<div class="cast-container">
    <?php
    $castMembers = ContentManager::getCast();
    foreach ($castMembers as $cast) {
        loadTemplate('cast_card', ['cast' => $cast]);
    }
    ?>
</div>