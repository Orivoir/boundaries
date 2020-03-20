<?php
namespace Boundaries\Interfaces;

interface InternalParserInterface {

    /**
     * partial parser are internal parser
     */

    public function parseTimeBlock(): self;

    public function parseSleepTimeout(): self;

    public function parseMaxConnect(): self;
}
