<div class="alert-success">
    ✅ Votre réservation a bien été enregistrée !
</div>

<div class="card">
    <h2 style="margin-bottom: 20px;">Récapitulatif de votre réservation</h2>

    <table>
        <tr>
            <th>Nom</th>
            <td><?= htmlspecialchars($booking['client_nom']) ?></td>
        </tr>
        <tr>
            <th>E-mail</th>
            <td><?= htmlspecialchars($booking['client_email']) ?></td>
        </tr>
        <tr>
            <th>Hôtel</th>
            <td><?= htmlspecialchars($booking['hotel_nom']) ?></td>
        </tr>
        <tr>
            <th>Adresse</th>
            <td><?= htmlspecialchars($booking['hotel_adresse']) ?></td>
        </tr>
        <tr>
            <th>Chambre n°</th>
            <td><?= (int) $booking['chambre_numero'] ?></td>
        </tr>
        <tr>
            <th>Arrivée</th>
            <td><?= htmlspecialchars(date('d/m/Y', strtotime($booking['date_debut']))) ?></td>
        </tr>
        <tr>
            <th>Départ</th>
            <td><?= htmlspecialchars(date('d/m/Y', strtotime($booking['date_fin']))) ?></td>
        </tr>
        <tr>
            <th>Réservation créée le</th>
            <td><?= htmlspecialchars(date('d/m/Y à H:i', strtotime($booking['date_creation']))) ?></td>
        </tr>
    </table>

    <a href="index.php" class="btn" style="margin-top: 20px;">Retour à l'accueil</a>
</div>
