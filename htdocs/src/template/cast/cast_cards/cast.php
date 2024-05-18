<!-- Cast Item Card -->
<div class="cast_card card mb-3">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($cast['name']); ?></h5>
        <div class="card-text">
            <strong>Known For:</strong>
            <ul>
                <?php foreach ($cast['knownFor'] as $title) : ?>
                    <li><?= htmlspecialchars($title); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <p class="card-text"><strong>Profession:</strong> <?= htmlspecialchars($cast['profession']); ?></p>
        <p class="card-text"><strong>Birth Year:</strong> <?= !empty($cast['birthYear']) ? htmlspecialchars($cast['birthYear']) : 'N/A'; ?></p>
        <p class="card-text"><strong>Death Year:</strong> <?= !empty($cast['deathYear']) ? htmlspecialchars($cast['deathYear']) : 'N/A'; ?></p>
    </div>
</div>