<?php

namespace Boundaries\Cores;

use Boundaries\Cores\ParseOptionsSettings as ParseOptions;
use Boundaries\Functions\PaamayimClass as StaticClass ;

/**
 * @class FieldView - injector dependencies from field settings views
 */
class FieldView {

    private $data ;

    private $isDev ;
    private $timeBlock ;
    private $sleepTimeout ;
    private $parser ;
    private $unity ;

    public function __construct() {

        $this->parser = new ParseOptions() ;

        $this->data = $this->parser->parse() ;

        $this->isDev = $this->data['is-dev'] ;
        $this->timeBlock = $this->data['time-block'] ;
        $this->sleepTimeout = $this->data['sleep-timeout'] ;
        $this->maxConnect = $this->data['max-connect'] ;

        $this->unity = $this->parser->getOptionDatas()[ 'unity_boundaries_field_time_block' ] ;
    }

    static public function getStaticClass() {

        return StaticClass::class ;
    }

    public function getIsDev(): bool {

        return $this->isDev ;
    }

    public function getTimeBlock(): int {

        return $this->timeBlock ?? StaticClass::DEFAULT_TIMESTAMP_BLOCK ;
    }

    public function getMaxConnect(): int {

        return $this->maxConnect ?? StaticClass::DEFAULT_MAX_TRY_CONNECT ;
    }

    public function getSleepTimeout(): int {

        return $this->sleepTimeout ?? StaticClass::DEFAULT_SLEEP_CONNECT ;
    }

    public function getUnity(): string {

        return $this->unity ?? "second" ;
    }

    public function getParser(): ParseOptions {

        return $this->parser ;
    }
}
