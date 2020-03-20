<?php

use Boundaries\Cores\FieldView ;

$currentOptions = new FieldView() ;
?>

<!-- content fields checkbox switch state mode development -->
<input
    type="checkbox"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
    <?= $currentOptions->getIsDev() ? "checked": "" ?>
/>

<p class="description">
    After authentication is lock wait only 10 seconds and not timeout sleep is add and an state log on admin form page , <strong>use in development only</strong>.
</p>
