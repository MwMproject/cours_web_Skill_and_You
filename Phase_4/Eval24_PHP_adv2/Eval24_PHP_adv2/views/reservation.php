<h2 style="margin-bottom: 20px;">Réserver une chambre</h2>

<?php if (!empty($error)): ?>
    <div class="alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="index.php?page=reservation">

        <!-- Informations client -->
        <h3 style="margin-bottom: 16px;">Vos informations</h3>

        <div class="form-group">
            <label for="nom">Nom complet</label>
            <input
                type="text"
                id="nom"
                name="nom"
                required
                placeholder="Ex : Dupont Jean"
                value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
            >
        </div>

        <div class="form-group">
            <label for="email">Adresse e-mail</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                placeholder="Ex : jean.dupont@email.com"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            >
        </div>

        <!-- Choix de l'hôtel -->
        <h3 style="margin: 20px 0 16px;">Votre séjour</h3>

        <div class="form-group">
            <label for="hotel_id">Hôtel</label>
            <select id="hotel_id" name="hotel_id" required>
                <option value="">-- Choisissez un hôtel --</option>
                <?php foreach ($hotels as $hotel): ?>
                    <option
                        value="<?= (int) $hotel['id'] ?>"
                        <?= (int) ($_POST['hotel_id'] ?? $_GET['hotel_id'] ?? 0) === (int) $hotel['id'] ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($hotel['nom']) ?> — <?= htmlspecialchars($hotel['adresse']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="date_debut">Date d'arrivée</label>
            <input
                type="date"
                id="date_debut"
                name="date_debut"
                required
                min="<?= date('Y-m-d') ?>"
                value="<?= htmlspecialchars($_POST['date_debut'] ?? '') ?>"
            >
        </div>

        <div class="form-group">
            <label for="date_fin">Date de départ</label>
            <input
                type="date"
                id="date_fin"
                name="date_fin"
                required
                min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                value="<?= htmlspecialchars($_POST['date_fin'] ?? '') ?>"
            >
        </div>

        <button type="submit" class="btn" style="margin-top: 8px;">
            Confirmer la réservation
        </button>

    </form>
</div>
