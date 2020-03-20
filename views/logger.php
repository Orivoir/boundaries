<?php
use Boundaries\Functions\PaamayimClass as StaticClass ;
?>

<div class="boundaries-dev-logger close">

    <div class="open-content">

        <div class="boundaries-close boundaries-toggle-state">
            &times;
        </div>

        <h2>
            <em>Boundaries</em> logger development:
        </h2>

        <p>
            attempt connect:
            <strong>
            <?= $_SESSION['try-connect'] ?? 0 ?>/
            <?= $datasOptions['max-connect'] ?></strong>
        </p>

        <p>
            authentication is lock:
            <strong><?= StaticClass::getIsBlock() ? "yes":"no" ?></strong>
        </p>

        <p>
            timeout before authorize connect:
            <strong> <?= !StaticClass::getIsBlock() ? "N/A": ( ( ( new \DateTime )->getTimestamp() - $_SESSION['date-block'] ) . "seconds / 10seconds" ) ?> </strong>
        </p>

    </div>

    <div class="boundaries-open boundaries-toggle-state"></div>

</div>

<style>
    <?php require PATH_STYLE . '/logger.css' ; ?>
</style>

<script>
    <?php require PATH_SCRIPT . '/logger.js' ; ?>
</script>
