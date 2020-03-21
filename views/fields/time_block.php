<?php

use Boundaries\Cores\FieldView ;

$currentOptions = new FieldView() ;

$staticClass = FieldView::getStaticClass() ;

$unity = $currentOptions->getUnity() ;

$constUnity = $unity == 'second' ?
    $staticClass::SECOND:
    $unity == 'hours' ?
    $staticClass::HOURS : $staticClass::MINUTE
;

$fieldType = "time-block" ;

?>
<!-- content fields range + select define timeout before remove lock authentication -->
<input
    id="boundaries-range-time-block"
    type="range"
    min="1"
    max="250"
    value="<?= $staticClass::convertTimestamp( $currentOptions->getTimeBlock() , $constUnity ) ?>"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
    class="boundaries-hide"
/>

<section
    class="boundaries-range-wrap"
    data-attach-selector="#boundaries-range-time-block"
>
    <div class="boundaries-range-bar">
        <div class="boundaries-range-inner"></div>
        <span class="boundaries-range-value">
            <?= $currentOptions->getSleepTimeout() ?>
        </span>
    </div>
</section>



<select name="boundaries_options[unity_<?= esc_attr( $args['label_for'] ); ?>]">

    <option value="second" <?= $unity == "second" ? "selected": "" ?> >
        second
    </option>

    <option value="minute" <?= $unity == "minute" ? "selected": "" ?> >
        minute
    </option>

    <option value="hours" <?= $unity == "hours" ? "selected": "" ?> >
        hours
    </option>
</select>

<?php
    require __DIR__ . '/descriptions.php' ;
?>