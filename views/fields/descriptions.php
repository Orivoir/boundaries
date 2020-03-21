<?php

$constsValue = [
    "time-block" => [
        "default" => $staticClass::DEFAULT_TIMESTAMP_BLOCK ,
        "max" => $staticClass::MAX_TIMESTAMP_BLOCK_RECOMMANDED ,
        "min" => $staticClass::MIN_TIMESTAMP_BLOCK_RECOMMANDED ,
        "is-time-value" => true
    ] ,
    "sleep-timeout" => [
        "default" => $staticClass::DEFAULT_SLEEP_CONNECT ,
        "max" => $staticClass::MAX_SLEEP_CONNECT_RECOMMANDED ,
        "min" => $staticClass::MIN_SLEEP_CONNECT_RECOMMANDED ,
        "is-time-value" => true
    ] ,
    "max-connect" => [
        "default" => $staticClass::DEFAULT_MAX_TRY_CONNECT ,
        "max" => $staticClass::MAX_MAX_TRY_CONNECT_RECOMMANDED ,
        "min" => $staticClass::MIN_MAX_TRY_CONNECT_RECOMMANDED ,
        "is-time-value" => false
    ]

] ;

$values = $constsValue[ $fieldType ] ;

if( is_array( $values ) ) {

    $staticClass::showDescribeField( $values ) ;
}

if( $currentOptions->getIsDev() ) {

    ?>
    <hr>
    <p class="description">
        <?=  $staticClass::infosFieldIsDev() ?>
    </p>
    <?php

}

?>
