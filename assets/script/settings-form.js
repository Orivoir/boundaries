document.addEventListener('DOMContentLoaded' , () => {

    const isDevCheckbox = document.querySelector('.boundaries-checkbox-is-dev input[type="checkbox"]') ;
    const isLoggerCheckbox = document.querySelector('.boundaries-checkbox-is-logger input[type="checkbox"]') ;

    let lastStatusLogger = isLoggerCheckbox.checked ;

    const checkStateRelationBetweenCheckbox = () => {

        if( isDevCheckbox.checked ) {

            lastStatusLogger = isLoggerCheckbox.checked ;
            isLoggerCheckbox.checked = true ;
            isLoggerCheckbox.disabled = true ;
            isLoggerCheckbox.style.cursor = "default" ;
        } else {

            isLoggerCheckbox.checked = lastStatusLogger ;
            isLoggerCheckbox.disabled = false ;
            isLoggerCheckbox.style.cursor = "pointer" ;
        }

    } ;

    checkStateRelationBetweenCheckbox() ;

    isDevCheckbox.addEventListener(
        'change' ,
        checkStateRelationBetweenCheckbox
    ) ;

    // custom range fields

    const px2rangeValue = (
        rangeInput ,
        customBarRange ,
        customInnerRange ,
        pxValue
    ) => {

        const maxValue = rangeInput.max ;
        const minValue = rangeInput.min ;

        const wRangePhisycal = customBarRange.offsetWidth - customInnerRange.offsetWidth ;

        const wRangeVirtual = maxValue - minValue ;

        const ratio = wRangePhisycal / wRangeVirtual ;

        return pxValue / ratio ;
    } ;

    const rangeValue2percent = (
        rangeInput ,
        rangeValue
    ) => {

        const maxValue = rangeInput.max ;
        const minValue = rangeInput.min ;

        const pct = ( 1 / ( ( maxValue - minValue ) / rangeValue ) * 100 ) ;

        // then currentValue == 0
        if( pct === Infinity ) return 0 ;

        return pct ;
    } ;

    document.addEventListener('pointerup' , () => {

        document.body.classList.remove('drag-drop') ;

        document.querySelectorAll('.boundaries-range-wrap .boundaries-range-bar')
        .forEach( customBarRange => {

            customBarRange._isDown = false ;

            customBarRange.querySelector('.boundaries-range-value').classList.remove('open') ;
        }  ) ;

    } ) ;

    document.addEventListener('mousemove' , e => {

        const moveX = e.movementX ;

        document.querySelectorAll('.boundaries-range-wrap .boundaries-range-bar')
        .forEach( customBarRange => {

            if( customBarRange._isDown ) {

                const innerCustomRange = customBarRange.querySelector('.boundaries-range-inner') ;
                const markRangeValue = customBarRange.querySelector('.boundaries-range-value') ;

                if(
                    innerCustomRange.offsetLeft + moveX > 0 &&
                    innerCustomRange.offsetLeft + moveX < customBarRange.offsetWidth - innerCustomRange.offsetWidth
                ) {

                    const rangeInput = document.querySelector( customBarRange.parentNode.getAttribute('data-attach-selector') ) ;

                    const newRangeValue = px2rangeValue(
                        rangeInput ,
                        customBarRange ,
                        innerCustomRange ,
                        ( innerCustomRange.offsetLeft + moveX )
                    ) ;

                    markRangeValue.textContent = parseInt( newRangeValue ) ;

                    rangeInput.setAttribute('value' , parseInt( newRangeValue ) ) ;

                    innerCustomRange.style.left = ( innerCustomRange.offsetLeft + moveX ) + "px" ;
                }
            }
        }  ) ;


    } ) ;

    document
        .querySelectorAll('.boundaries-range-wrap')
        .forEach( rangeWrap => {

            const rangeInput = document.querySelector( rangeWrap.getAttribute('data-attach-selector') ) ;

            const innerCustomRange = rangeWrap.querySelector('.boundaries-range-inner') ;

            const currentValue = rangeInput.value ;

            const customBarRange = rangeWrap.querySelector('.boundaries-range-bar') ;

            const customInnerRange = customBarRange.querySelector('.boundaries-range-inner') ;

            const markRangeValue = customBarRange.querySelector('.boundaries-range-value') ;

            markRangeValue.textContent = rangeInput.getAttribute('value') ;

            innerCustomRange.style.left =  rangeValue2percent( rangeInput , currentValue ) + "%" ;

            customBarRange._isDown = false ;

            customBarRange.addEventListener('mouseenter' , function() {

                this.querySelector('.boundaries-range-value').classList.add('open') ;

            } ) ;

            customBarRange.addEventListener('mouseout' , function() {

                if( !this._isDown ) {

                    this.querySelector('.boundaries-range-value').classList.remove('open') ;
                }

            } ) ;

            customBarRange.addEventListener('pointerdown' , function(e) {

                document.body.classList.add('drag-drop') ;

                this.querySelector('.boundaries-range-value').classList.add('open') ;

                this._isDown = true ;

                const xPos = e.offsetX ;

                innerCustomRange.style.left = xPos + "px" ;

                const newRangeValue = px2rangeValue(
                    rangeInput ,
                    customBarRange ,
                    customInnerRange ,
                    xPos
                ) ;

                const markRangeValue = customBarRange.querySelector('.boundaries-range-value') ;

                markRangeValue.textContent = parseInt(newRangeValue) ;

                rangeInput.setAttribute('value' , parseInt(newRangeValue) ) ;

            } ) ;

        } )
    ;

} ) ;