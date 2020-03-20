<?php

define('CLASSNAME_CORES' , array(
    'ParseOptionsSettings' ,
    'FieldView'
) ) ;

function coresAutoloader(
    string $namespace
): void {

    $classNameURI = explode( "\\" , $namespace) ;

    $classNameIndex = array_key_last( $classNameURI ) ;

    $className = $classNameURI[$classNameIndex] ;

    if( in_array( $className , CLASSNAME_CORES ) ) {

        require_once PATH_CORES . '/' . $className . '.php' ;
    }
}

spl_autoload_register('coresAutoloader') ;
