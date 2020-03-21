<?php
namespace Boundaries\Interfaces ;

interface InternalParserInterface {

    /**
     * partial parser are internal parser
     */

    /**
     * parse data of settings field for time lock authentication
     */
    public function parseTimeBlock(): ?InternalParserInterface ;

    /**
     * parse data of settings field for sleep timeout to authentication
     */
    public function parseSleepTimeout(): ?InternalParserInterface ;

    /**
     * parse data of settings field for maximum attempt authentication before lock
     */
    public function parseMaxConnect(): ?InternalParserInterface ;
}
