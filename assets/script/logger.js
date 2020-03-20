const onDomLoad = () => {

    const wrapLogger = document.querySelector('.boundaries-dev-logger') || null

    if( !wrapLogger ) {

        return;
    }

    function toggleStateLogger() {

        wrapLogger.classList.toggle( "close" ) ;
    }

    wrapLogger
        .querySelectorAll('.boundaries-toggle-state')
        .forEach( toggleEl => {

            toggleEl.addEventListener('click' , () => {

                toggleStateLogger() ;


            } ) ;

        } )
    ;

} ;

document.addEventListener('DOMContentLoaded' , onDomLoad ) ;
