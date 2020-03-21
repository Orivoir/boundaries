<?php
namespace Boundaries\Interfaces;

use Boundaries\Interfaces\BuildFieldCallbackInterface;

interface OptionApiInterface extends BuildFieldCallbackInterface {

    /**
     * initialize new settings content for manage options
     */
    static public function settingsInit(): void ;

    /**
     * add field inner section from Wordpress function native: `add_settings_field`
     */
    static public function saveField(
        string $nameField ,
        string $describe ,
        string $section ,
        string $labelFor
    ): void ;

    /**
     * show header para of settings section page
     */
    static public function sectionDevelopersCb( array $args ): void ;

    /**
     * define menu inner admin tool bar
     */
    static public function optionsPage(): void ;

    /**
     * call all cores content page options from admin
     * only if user have right roles: 'manage_options'
     */
    static public function optionsPageHtml(): void ;

}
