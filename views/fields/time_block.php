<?php

use Boundaries\Cores\FieldView ;

$currentOptions = new FieldView() ;

$staticClass = FieldView::getStaticClass() ;

$unity = $currentOptions->getUnity() ;

?>
<!-- content fields range + select define timeout before remove lock authentication -->
<input
    type="range"
    min="1"
    max="250"
    value="<?= $currentOptions->getTimeBlock() ?>"
    name="boundaries_options[<?= esc_attr( $args['label_for'] ); ?>]"
/>

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

<p class="description">
    the currently value is
    <strong>
        <?= $staticClass::convertTimestamp( $currentOptions->getTimeBlock() ) ?>
    </strong>.
</p>

<p class="description">
    the standard value is
    <strong>
        <?= $staticClass::convertTimestamp( $staticClass::DEFAULT_TIMESTAMP_BLOCK ) ?>
    </strong>.
</p>

<p class="description">
    the maximum recommanded is
    <strong>
        <?= $staticClass::convertTimestamp( $staticClass::MAX_TIMESTAMP_BLOCK_RECOMMANDED ) ?>
    </strong>.
</p>

<p class="description">
    the minimum recommended value is
    <strong>
        <?= $staticClass::convertTimestamp( $staticClass::MIN_TIMESTAMP_BLOCK_RECOMMANDED ) ?>
    </strong>.
</p>

<?php
if( $currentOptions->getIsDev() ) {

    ?>
    <hr>
    <p class="description">
        <?=  self::infosFieldIsDev() ?>
    </p>
    <?php

}
?>