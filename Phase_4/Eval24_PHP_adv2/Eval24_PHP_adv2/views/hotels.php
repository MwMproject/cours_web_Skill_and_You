<h2 style="margin-bottom: 20px;">Nos hôtels</h2>

<?php if (empty($hotels)): ?>
    <div class="card">
        <p>Aucun hôtel disponible pour le moment.</p>
    </div>
<?php else: ?>
    <?php foreach ($hotels as $hotel): ?>
        <div class="card">
            <h3><?= htmlspecialchars($hotel['nom']) ?></h3>
            <p style="color: #666; margin: 8px 0;">
                📍 <?= htmlspecialchars($hotel['adresse']) ?>
            </p>
            <a
                href="index.php?page=reservation&hotel_id=<?= (int) $hotel['id'] ?>"
                class="btn"
                style="margin-top: 12px;"
            >
                Réserver dans cet hôtel
            </a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
