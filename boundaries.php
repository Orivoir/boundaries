<?php
session_start() ;

/**
 * Plugin Name: Admin Boundaries
 * Description: Boundaries is an implement of an security handler the targeting native gaps of admin form
 * Version: 0.1.0
 * Author: Samuel Gaborieau
 */

use Boundaries\Cores\ParseOptionsSettings as ParseOptions ;
use Boundaries\Functions\PaamayimClass as StaticClass ;

define('PATH_SCRIPT' , __DIR__ . '/assets/script' ) ;
define('PATH_STYLE' , __DIR__ . '/assets/style' ) ;
define('PATH_VIEWS' , __DIR__ . '/views' ) ;

require_once __DIR__ . '/autoloader.php' ;
require_once __DIR__ . '/functions.php' ;

// mute authentication credentials from error message
add_filter('login_errors' ,  [
    StaticClass::class ,
    'onLoginErrors'
] ) ;

$datasOptions = ( new ParseOptions() )->parse() ;

$isDev = $datasOptions['is-dev'] ;
$isLogger = $datasOptions['is-logger'] ;

// check if post datas admin form
if(
    StaticClass::isLoginRequest()
) {
    // here try connect to admin form

    // init options from settings form
    StaticClass::setTimestampBlock( $datasOptions['time-block'] ) ;
    StaticClass::setMaxTryConnect( $datasOptions['try-connect'] ) ;
    StaticClass::setSleepConnect( $datasOptions['sleep-timeout'] ) ;

    // Zzzz ...
    sleep( StaticClass::$sleepConnect ) ;

    $isExcedeed = StaticClass::upAttemptConnectCount() ;
    $isAlreadyBlock = StaticClass::getIsBlock() ;

    if( $isAlreadyBlock ) {

        if( !StaticClass::isEndTimeoutLock() ) {

            StaticClass::onRejectAuthenfication( StaticClass::ALREADY_REJECT ) ;

        } else {
            // unset: session datas
            StaticClass::onReset() ;
        }

    } else if( $isExcedeed ) {

        StaticClass::onRejectAuthenfication( StaticClass::FIRST_REJECT ) ;
    }

} else if( StaticClass::isLoginPage() && StaticClass::isEndTimeoutLock() ) {

    StaticClass::onReset() ;
}

// for dev use
if( StaticClass::isLoginPage() && ( $isDev || $isLogger ) ) {

    // show logger after update session data
    require PATH_VIEWS . '/logger.php' ;
}

// Fires after the user has successfully logged in.
add_action('wp_login' , [
    StaticClass::class ,
    'onReset'
] ) ;


// init: Settings/Options API
// https://developer.wordpress.org/plugins/settings/settings-api/

/**
 * fire then screen admin is loaded
 */
add_action( 'admin_init', [
    StaticClass::class ,
    'settingsInit'
] ) ;

/**
* register: '::optionsPage' to the admin_menu action hook
*/
add_action( 'admin_menu',
    [ StaticClass::class , 'optionsPage']
) ;
