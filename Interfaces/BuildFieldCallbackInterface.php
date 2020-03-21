<?php
namespace Boundaries\Interfaces;

interface BuildFieldCallbackInterface {

    /**
     * callback build field mode dev
     */
    static public function isDevCb( array $args ): void ;

    /**
     * callback build field max attempt authentication
     */
    static public function maxConnectCb( array $args ): void ;

    /**
     * callback build field time lock authentication
     */
    static public function timeBlockCb( array $args ): void ;

    /**
     * callback build field sleep timeout between request authentication
     */
    static public function sleepTimeoutCb( array $args ): void ;

    /**
     * callback build field enabled logger from form admin page
     */
    static public function isLoggerCb( array $args ): void ;

}
