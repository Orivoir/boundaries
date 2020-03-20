<?php
namespace Boundaries\Interfaces;

interface HooksInterface {

    /**
     * hooks method
     * filter: 'login_errors'
     * https://developer.wordpress.org/reference/hooks/login_errors/
     */
    static public function onLoginErrors( string $originalError ): string ;

    /**
     * hooks method
     * filter: 'login_error'
     * https://developer.wordpress.org/reference/hooks/login_errors/
     */
    static public function onBlockAuthentication( string $originalError ): string ;

    /**
     * hook method
     * action: 'wp_login'
     * https://developer.wordpress.org/reference/hooks/wp_login/
     */
    static public function onReset(): void ;
}