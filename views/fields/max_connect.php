<?php

use Boundaries\Cores\FieldView ;

$currentOptions = new FieldView() ;

$staticClass = FieldView::getStaticClass() ;

$fieldType = "max-connect" ;

?>
<!-- content fields input range max attempts connect before lock authentication -->
<input
    id="boundaries-range-max-connect"
    type="range"
    min="1"
    max="100"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
    value="<?= $currentOptions->getMaxConnect() ?>"
    class="boundaries-hide"
/>

<section
    class="boundaries-range-wrap"
    data-attach-selector="#boundaries-range-max-connect"
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