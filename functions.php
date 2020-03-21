<?php
namespace Boundaries\Functions ;

use Boundaries\Interfaces\OptionApiInterface ;
use Boundaries\Interfaces\HooksInterface ;

class PaamayimClass implements OptionApiInterface, HooksInterface {

    /**
     * private construct but this is not an pattern singleton ,
     * contains only static methods
     * not define inner global namespace for not
     * conflict name with another Plugin or kernel code of Wordpress
     * because reject of naming with an format: 'prefix_functionName'
     */
    private function __construct() {/* silence is <feature /> */}

    /**
     * @var FIRST_REJECT
     * init SESSION datas date-block and is-block from `onRejectAuthenfication`
     */
    const FIRST_REJECT = true ;
    /**
     * @var ALREADY_REJECT
     * opposite of `FIRST_INIT` const
     */
    const ALREADY_REJECT = false ;

    const SECOND = 1 ;
    const MINUTE = 2 ;
    const HOURS = 3 ;

    // unity time is used as UNIX timestamp

    const DEFAULT_TIMESTAMP_BLOCK = ( 1 * 60 * 60 * 3 ) ; // 3hours
    const DEFAULT_MAX_TRY_CONNECT = 5 ;
    const DEFAULT_SLEEP_CONNECT = 1 ; // 1second

    const MAX_TIMESTAMP_BLOCK = ( 1*60*60*250 ) ; // 250hours
    const MAX_MAX_TRY_CONNECT = 100 ;
    const MAX_SLEEP_CONNECT = 20 ;

    const MIN_TIMESTAMP_BLOCK = 10 ; // 10seconds min for use in dev
    const MIN_MAX_TRY_CONNECT = 1 ;
    const MIN_SLEEP_CONNECT = 0 ; // for can disabled this security

    const MAX_TIMESTAMP_BLOCK_RECOMMANDED = self::MAX_TIMESTAMP_BLOCK ;
    const MAX_MAX_TRY_CONNECT_RECOMMANDED = 10 ;
    const MAX_SLEEP_CONNECT_RECOMMANDED = 5 ;

    const MIN_TIMESTAMP_BLOCK_RECOMMANDED = ( 1*60*30 ) ; // 30min
    const MIN_MAX_TRY_CONNECT_RECOMMANDED = 3 ;
    const MIN_SLEEP_CONNECT_RECOMMANDED = 1 ;

    static $timestampBlock = self::DEFAULT_TIMESTAMP_BLOCK ;
    static $maxTryConnect = self::DEFAULT_MAX_TRY_CONNECT ;
    static $sleepConnect = self::DEFAULT_SLEEP_CONNECT ;

    /**
     * for dynamic call of datas normalizers
     * if absent you can use this magic method ^.^
     */
    static public function Zzzz( $val ) {

        return $val ;
    }

    static public function showDescribeField( array $values ): void {

        $normalizer = $values['is-time-value'] ? "convertTimestamp": "Zzzz" ;

        ?>

        <p class="description">
            the standard value is
            <strong>
                <?= self::$normalizer( $values['default'] ) ?>
            </strong>.
        </p>

        <p class="description">
            the maximum recommanded is
            <strong>
                <?= self::$normalizer( $values['max'] ) ?>
            </strong>.
        </p>

        <p class="description">
            the minimum recommended value is
            <strong>
                <?= self::$normalizer( $values['min'] ) ?>
            </strong>.
        </p>
        <?php
    }

    // convert timestamp to bigger time unity for an render HTML
    static public function convertTimestamp(
        int $unixTimestamp ,
        int $unityTime = NULL
    ): string {

        if( !!$unityTime ) {

            if( $unityTime === 1 ) {

                return $unixTimestamp ;
            } else if( $unityTime == 2 ) {

                return ( (int) ($unixTimestamp / 60) ) ;
            } else {

                return ((int) ($unixTimestamp / 3600)) ;
            }
        }

        if( $unixTimestamp / 3600 >= 1 ) {

            return ( (int) ($unixTimestamp / 3600) ) . ' hours' ;

        } else if( $unixTimestamp / 60 >= 1 ) {

            return ( (int) ($unixTimestamp / 60) ) . ' minutes'  ;
        }

        return $unixTimestamp . ' seconds' ;
    }

    static public function infosFieldIsDev(): string {

        return '<strong>disabled development mode for show your real config</strong>' ;
    }

    static public function setTimestampBlock( ?int $timestampBlock ): void {

        self::$timestampBlock = is_int( $timestampBlock ) ?
            $timestampBlock : self::DEFAULT_TIMESTAMP_BLOCK
        ;

        if( self::$timestampBlock > self::MAX_TIMESTAMP_BLOCK ) {
            self::$timestampBlock = self::MAX_TIMESTAMP_BLOCK ;

        } else if( self::$timestampBlock < self::MIN_TIMESTAMP_BLOCK ) {
            self::$timestampBlock = self::MIN_TIMESTAMP_BLOCK ;
        }
    }

    static public function setMaxTryConnect( ?int $maxTryConnect ): void {

        self::$maxTryConnect = \is_int( $maxTryConnect ) ? $maxTryConnect: self::DEFAULT_MAX_TRY_CONNECT ;

        if( self::$maxTryConnect > self::MAX_MAX_TRY_CONNECT ) {
            self::$maxTryConnect = self::MAX_MAX_TRY_CONNECT ;

        } else if( self::$maxTryConnect < self::MIN_MAX_TRY_CONNECT ) {
            self::$maxTryConnect = self::MIN_MAX_TRY_CONNECT ;
        }
    }

    static public function setSleepConnect( ?int $sleepConnect ): void {

        self::$sleepConnect = \is_int( $sleepConnect ) ? $sleepConnect: self::DEFAULT_SLEEP_CONNECT ;

        if( self::$sleepConnect > self::MAX_SLEEP_CONNECT ) {
            self::$sleepConnect = self::MAX_SLEEP_CONNECT ;

        } else if( self::$sleepConnect < self::MIN_SLEEP_CONNECT ) {
            self::$sleepConnect = self::MIN_SLEEP_CONNECT ;
        }
    }

    static public function isLoginPage(): bool {

        $currentURI = parse_url( $_SERVER['REQUEST_URI'] )['path'] ;
        $adminURI = parse_url( wp_login_url() )['path'] ;

        return $currentURI == $adminURI ;
    }

    static public function isEndTimeoutLock(
        ?int $sleepTimeout = NULL
    ): bool {

        $dateStartBlock = $_SESSION['date-block'] ?? NULL ;

        if( !$dateStartBlock ) {
            // @TODO: should \\throw: LogicError or ContextError
            return false ;
        }

        if( !$sleepTimeout ) {

            $sleepTimeout = self::$timestampBlock ;
        }

        $currentDate = ( new \DateTime() )->getTimestamp() ;

        return !( ( $currentDate - $dateStartBlock ) < $sleepTimeout ) ;
    }

    static public function getIsBlock(): bool {

        return !!$_SESSION['is-block'] ;
    }

    static public function isLoginRequest(): bool {

        return (
            !is_admin() &&
            isset( $_POST['log'] ) &&
            isset( $_POST['pwd'] ) &&
            self::isLoginPage()
        ) ;
    }

    // data session try connect count ++
    static public function upAttemptConnectCount(): bool {

        if( isset( $_SESSION['try-connect'] ) ) {

            $_SESSION['try-connect']++ ;

        } else {

            $_SESSION['try-connect'] = 1 ;
        }

        if( $_SESSION['try-connect'] > self::MAX_MAX_TRY_CONNECT ) {

            $_SESSION['try-connect'] = self::MAX_MAX_TRY_CONNECT ;
        }

        return $_SESSION['try-connect'] >= self::MAX_MAX_TRY_CONNECT ;
    }

    static public function onRejectAuthentication( bool $initReject = false ): void {

        // delete post data ( for force reject authentication from: 'wp-login.php' with empty datas )
        unset( $_POST['pwd'] ) ;
        unset( $_POST['log'] ) ;

        // alternate error message with filter hook's
        remove_filter('login_errors' ,
            [ self::class , 'onLoginErrors' ]
        ) ;

        add_filter('login_errors' ,
            [ self::class , 'onBlockAuthentication' ]
        ) ;

        if( !!$initReject ) {
            // init date block and is-block
            $_SESSION['date-block'] = ( new \DateTime() )->getTimestamp() ;
            $_SESSION['is-block'] = true ;
        }

    }

    /**
     * @see HooksInterface
     */
    static public function onLoginErrors( string $originalError ): string {

        // delete original error because
        // return generic error *e.g: "credentials error"*
        unset( $originalError ) ;

        return "<strong>ERROR:</strong> credentials error." ;
    }

    /**
     * @see HooksInterface
     */
    static public function onBlockAuthentication( string $originalError ): string {

        // delete original error because
        // return generic error *e.g: "credentials error"*
        unset( $originalError ) ;

        return "<strong>ERROR:</strong> you can't authentication because will try connect greater than to many times." ;
    }

    /**
     * @see HooksInterface
     */
    static public function onReset(): void {

        $s = $_SESSION ;

        if( isset( $s['try-connect'] ) ) {

            unset( $_SESSION['try-connect'] ) ;

        } if( isset( $s['date-block'] ) ) {

            unset( $_SESSION['date-block'] ) ;

        } if( isset( $s['is-block'] ) ) {

            unset( $_SESSION['is-block'] ) ;
        }
    }

    static public function saveAllFields(): void {

        // save field range for set max connect
        self::saveField(
            'maxConnect' , // name field
            'Maximum number of connection attempts' , // describe
            'section_developers' , // attach field to section
            'max_connect' , // label field
        ) ;

        // save field range for sleep timeout for connect attempt boundaries by seconds
        self::saveField(
            'sleepTimeout' ,
            'Sleep timeout for connect attempt boundaries by seconds' ,
            'section_developers' ,
            'sleep_timeout'
        ) ;

        // save field range + select for set timeout after lock authentication
        self::saveField(
            'timeBlock' ,
            'Waiting time after connection blocking before unblocking connection attempt' ,
            'section_developers' ,
            'time_block'
        ) ;

        // save field checkbox for switch state of development mode
        self::saveField(
            'isDev' ,
            'enable development mode' ,
            'section_developers' ,
            'is_dev' ,
            'boundaries-checkbox-is-dev'
        ) ;

        self::saveField(
            'isLogger' ,
            'enable logger from admin form' ,
            'section_developers' ,
            'is_logger' ,
            'boundaries-checkbox-is-logger'
        ) ;
    }

    /**
     * @see OptionApiInterface
     */
    static public function settingsInit(): void {

        register_setting( 'boundaries', 'boundaries_options' ) ;

        add_settings_section(
            'boundaries_section_developers',
            __( 'customize the level of security required for the administration form', 'boundaries' ),

            [ self::class ,  'sectionDevelopersCb' ],

            'boundaries'
        ) ;

        self::saveAllFields() ;
    }

    /**
     * @see OptionApiInterface
     */
    static public function sectionDevelopersCb( array $args ): void {

        ?>
        <p id="<?= esc_attr( $args['id'] ); ?>">

            <?php
            esc_html_e(
                'The default values correspond to a standard requirement.',
                'boundaries'
            ) ;
            ?>

        </p>
        <?php
    }

    /**
     * @see OptionApiInterface
     */
    static public function saveField(
        string $nameField ,
        string $describe ,
        string $section ,
        string $labelFor ,
        string $class2add = ""
    ): void {

        $name = 'boundaries_' . $nameField ;
        $nameCb = $nameField . 'Cb' ;
        $sectionName = 'boundaries_' . $section ;
        $label = 'boundaries_field_' . $labelFor ;

        add_settings_field(
            $name , // as of WP 4.6 this value is used only internally
            // use $args' label_for to populate the id inside the callback
            __( $describe , 'boundaries' ),

            [ self::class , $nameCb ] ,

            'boundaries',
            $sectionName ,

            // $args from callback build field
            [
                'label_for' =>  $label ,
                'class' => 'boundaries_row ' . $class2add ,
                'boundaries_custom_data' => 'custom',
            ]
        ) ;

    }

    /**
     * @see OptionApiInterface
     */
    static public function optionsPage(): void {

        // add top level menu page
        add_menu_page(
            'Boundaries Settings',
            'Boundaries',

            'manage_options', // ROLES_USER
            'boundaries', // id menu
            [
                self::class ,
                'optionsPageHtml'
            ] // callback build content page
        ) ;
    }

    /**
     * @see OptionApiInterface
     */
    static public function optionsPageHtml(): void {

        // check ROLES_USER
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error(
                'boundaries_messages',
                'boundaries_message',
                __( 'Settings Saved', 'boundaries' ) // content and attach section
                , 'updated' // message type for CSS
            ) ;
        }

        // show error/update messages
        settings_errors( 'boundaries_messages' ); // call with id message

        require PATH_VIEWS . '/forms/manage_settings_form.php' ;
    }


    /**
     * @see OptionApiInterface
     */
    static public function isDevCb( array $args ): void {

        require PATH_VIEWS . '/fields/is_dev.php' ;
    }

    /**
     * @see OptionApiInterface
     */
    static public function maxConnectCb( array $args ): void {

        require PATH_VIEWS . '/fields/max_connect.php' ;
    }

    /**
     * @see OptionApiInterface
     */
    static public function timeBlockCb( array $args ): void {

        require PATH_VIEWS . '/fields/time_block.php' ;
    }

    /**
     * @see OptionApiInterface
     */
    static public function sleepTimeoutCb( array $args ): void {

        require PATH_VIEWS . '/fields/sleep_timeout.php' ;
    }

    /**
     * @see OptionApiInterface
     */
    static public function isLoggerCb( array $args ): void {

        require PATH_VIEWS . '/fields/is_logger.php' ;
    }
}
