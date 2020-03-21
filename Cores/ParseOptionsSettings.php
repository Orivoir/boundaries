<?php
namespace Boundaries\Cores ;

use Boundaries\Interfaces\InternalParserInterface ;

class ParseOptionsSettings implements InternalParserInterface {

    /**
     * @var optionDatas
     * native datas from: `get_option`
     */
    private $optionDatas ;

    /**
     * @var parseDatas
     * final datas after call: `parse` method
     */
    private $parseDatas ;

    /**
     * @var isDev
     * state checkbox: "enable development mode"
     */
    private $isDev ;

    /**
     * @var isLogger
     * state checkebox: "enable logger from admin form"
     */
    private $isLogger ;

    public function __construct() {

        $this->optionDatas = get_option(  'boundaries_options' ) ;
        $this->parseDatas = [] ;
        $this->isDev = isset( $this->optionDatas['boundaries_field_is_dev'] ) ;
        $this->isLogger = isset( $this->optionDatas['boundaries_field_is_logger'] ) ;

        $this->parseDatas['is-dev'] = $this->isDev ;
        $this->parseDatas['is-logger'] = $this->isLogger ;
    }

    public function getIsDev(): bool {

        return $this->isDev ;
    }

    public function getIsLogger(): bool {

        return $this->isLogger ;
    }

    public function getOption() {

        return $this->optionDatas ;
    }

    private function parseTimeUnity(
        string $timeBlockUnity ,
        int $timeBlockValue
    ): int {

        // parse unity time in UNIX timestamp

        if( $timeBlockUnity == "minute" ) {

            $timeBlockValue *= 60 ;

        } else if( $timeBlockUnity == "hours" ) {

            $timeBlockValue *= 3600 ;
        }

        return $timeBlockValue ;
    }

    /**
    * @see InternalParserInterface
    */
    public function parseTimeBlock(): ?InternalParserInterface {

        $optionsSettings = $this->optionDatas ;
        $isDev = $this->isDev ;

        if(
            isset( $optionsSettings['boundaries_field_time_block'] ) &&
            isset( $optionsSettings['unity_boundaries_field_time_block'] )
        ) {
            $timeBlockValue = $optionsSettings['boundaries_field_time_block'] ;
            $timeBlockUnity = $optionsSettings['unity_boundaries_field_time_block'] ;

            $timeBlockValue = $this->parseTimeUnity( $timeBlockUnity , $timeBlockValue ) ;

            if( $isDev ) {
                // in dev use

                $timeBlockUnity = "second" ;
                $timeBlockValue = 10 ;
            }

            // UNIX timestamp
            $this->parseDatas['time-block'] = $timeBlockValue ;
        } else {

            $this->parseDatas['time-block'] = NULL ;
        }

        return $this ;
    }

    /**
     * @see InternalParserInterface
     */
    public function parseSleepTimeout(): ?InternalParserInterface {

        $optionsSettings = $this->optionDatas ;
        $isDev = $this->isDev ;

        if( isset( $optionsSettings['boundaries_field_sleep_timeout'] ) ) {

            $sleepTimeout = $optionsSettings['boundaries_field_sleep_timeout'] ;

            if( $isDev ) {

                $sleepTimeout = 1 ;
            }

            $this->parseDatas['sleep-timeout'] = $sleepTimeout ;
        } else {

            $this->parseDatas['sleep-timeout'] = NULL ;
        }

        return $this ;

    }

    /**
     * @see InternalParserInterface
     */
    public function parseMaxConnect(): ?InternalParserInterface {

        $optionsSettings = $this->optionDatas ;

        if( isset(  $optionsSettings['boundaries_field_max_connect'] ) ) {

            $this->parseDatas['max-connect'] = $optionsSettings['boundaries_field_max_connect'] ;
        } else {

            $this->parseDatas['max-connect'] = NULL ;
        }

        return $this ;
    }

    /**
     * @method parse
     * public parse method call all internal parser
     */
    public function parse(): array {

        $this
            ->parseTimeBlock()
            ->parseSleepTimeout()
            ->parseMaxConnect()
        ;

        return $this->parseDatas ;
    }

    public function getDatas(): array {

        return $this->parseDatas ;
    }

    public function getParseDatas(): array {

        return $this->parseDatas ;
    }

    public function getOptionDatas(): array {

        return $this->optionDatas ;
    }
}
