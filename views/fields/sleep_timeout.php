<?php

use Boundaries\Cores\FieldView ;

$currentOptions = new FieldView() ;

$staticClass = FieldView::getStaticClass() ;

$fieldType = "sleep-timeout" ;

?>

<!-- content fields range define sleep timeout for connect attempt boundaries by seconds -->
<input
    id="boundaries-range-sleep-timeout"
    type="range"
    min="0"
    max="20"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
    value="<?= $currentOptions->getSleepTimeout() ?>"
    class="boundaries-hide"
/>

<section
    class="boundaries-range-wrap"
    data-attach-selector="#boundaries-range-sleep-timeout"
>
    <div class="boundaries-range-bar">
        <div class="boundaries-range-inner"></div>
        <span class="boundaries-range-value">
            <?= $currentOptions->getSleepTimeout() ?>
        </span>
    </div>
</section>


<?php
    require __DIR__ . '/descriptions.php' ;
?>