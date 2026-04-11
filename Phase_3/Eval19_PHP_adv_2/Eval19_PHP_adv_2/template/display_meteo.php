<h1>Météo</h1>
<ul>
    <?php foreach ($forecasts as $forecast): ?>
        <li>
            <p><?php echo $forecast['city'] ?> : <?php echo $forecast['date'] ?> (<?php echo $forecast['period'] ?>)
            </p>
            <p>Résumé : <?php echo $forecast['resume'] ?></p>
            <p>Température (min/max) : <?php echo $forecast['temp_min'] ?> / <?php echo $forecast['temp_max'] ?></p>
            <p><?php echo $forecast['comment'] ?></p>
        </li>
    <?php endforeach; ?>
</ul>
