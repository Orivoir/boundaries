<?php

define('INTERFACES_NAME' , array(
    'OptionApiInterface' ,
    'BuildFieldCallbackInterface' ,
    'HooksInterface' ,
    'InternalParserInterface'
) ) ;

function interfacesAutoloader(
    string $namespace
): void {

    $classNameURI = explode( "\\" , $namespace) ;

    $classNameIndex = array_key_last( $classNameURI ) ;

    $className = $classNameURI[$classNameIndex] ;

    if( in_array( $className , INTERFACES_NAME ) ) {

        require_once PATH_INTERFACES . '/' . $className . '.php' ;

    }

}

spl_autoload_register('interfacesAutoloader') ;
