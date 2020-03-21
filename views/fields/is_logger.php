<?php

use Boundaries\Cores\FieldView ;

$currentOptions = new FieldView() ;
?>

<!-- content fields checkbox enable logger from admin form page -->
<input
    type="checkbox"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
    <?= $currentOptions->getIsLogger() ? "checked": "" ?>
/>

<p class="description">
    Enable behaviour logger from admin login page
</p>