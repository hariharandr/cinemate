<!-- Movie Item Card -->
<div class="movie_card card mb-3">
    <div class="card-body">
        <h5 class="card-title">
            <?php
            // Check if the title length is less than 2, if it's valid, display it with the year; otherwise, display a default message or handle accordingly.
            echo strlen($movie['primaryTitle']) > 1 ? htmlspecialchars($movie['primaryTitle']) . " (" . htmlspecialchars($movie['startYear']) . ")" : "Title not available";
            ?>
        </h5>
        <!-- <h6 class="card-subtitle mb-2 text-muted"><?php // echo htmlspecialchars($movie['originalTitle']); 
                                                        ?></h6> -->
        <div class="card-text">
            <strong>Genres:</strong> <?= !empty($movie['genres']) ? htmlspecialchars($movie['genres']) : 'N/A'; ?>
        </div>
        <div class="card-text">
            <strong>Type:</strong> <?= htmlspecialchars($movie['titleType']); ?>
        </div>
        <div class="card-text">
            <strong>Year:</strong> <?= !empty($movie['startYear']) ? htmlspecialchars($movie['startYear']) : 'Unknown'; ?>
        </div>
        <div class="card-text">
            <strong>Runtime:</strong> <?= !empty($movie['runtimeMinutes']) ? htmlspecialchars($movie['runtimeMinutes']) . ' min' : 'N/A'; ?>
        </div>
        <div class="card-text">
            <strong>Adult Content:</strong> <?= $movie['isAdult'] === "1" ? 'Yes' : 'No'; ?>
        </div>
    </div>
</div>

