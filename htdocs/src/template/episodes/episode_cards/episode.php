<div class="episode_card card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($episode['primaryTitle']); ?></h5>
        <div class="card-text">
            <strong>Genres:</strong> <?= !empty($episode['genres']) ? htmlspecialchars($episode['genres']) : 'N/A'; ?>
        </div>
        <div class="card-text">
            <strong>Type:</strong> <?= htmlspecialchars($episode['titleType']); ?>
        </div>
        <div class="card-text">
            <strong>Year:</strong> <?= !empty($episode['startYear']) ? htmlspecialchars($episode['startYear']) : 'Unknown'; ?>
        </div>
        <div class="card-text">
            <strong>Runtime:</strong> <?= !empty($episode['runtimeMinutes']) ? htmlspecialchars($episode['runtimeMinutes']) . ' min' : 'N/A'; ?>
        </div>
        <div class="card-text">
            <strong>Adult Content:</strong> <?= $episode['isAdult'] === "1" ? 'Yes' : 'No'; ?>
        </div>
    </div>
</div>