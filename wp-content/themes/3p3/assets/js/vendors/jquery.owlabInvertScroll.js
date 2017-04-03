/*!
 *  InvertScroll plugin for jQuery 
 *  Version   : 1.0
 *  Date      : 2016-08-27
 *  Licence   : All rights reserved 
 *  Author    : owwwlab (Ehsan Dalvand & Alireza Jahandideh)
 *  Contact   : owwwlab@gmail.com
 *  Web site  : http://themeforest.net/user/owwwlab
 */

// Utility
if ( typeof Object.create !== 'function'  ){ // browser dose not support Object.create
    Object.create = function (obj){
        function F(){};
        F.prototype = obj;
        return new F();
    };
};

(function($) {
    
    invertScroll={
        init:function(options , elem){
            var self=this;
            self.elem = elem;
            self.$elem = $(elem);
            self.options = $.extend( {}, $.fn.olInvertScroll.options, options);

            self.initialOffset=self.$elem.offset().left;

            if (self.isTouchDevice()){
                self.touchDeviceFallback();
            }else{
                self.prepare();
                self.setDimensions();
                self.bindUIActions();
            }
        },
        prepare:function(){
            var self=this;
            self.options.$fixedElem.addClass('_em_fixed layout-padding');
        },
        setDimensions:function(){
            var self=this,
                $window=$(window),
                $body=$('body');

            self.windowWidth=$window.width();
            self.windowHeight=$window.height();

            var elemActualWidth=self.$elem.outerWidth()+self.initialOffset,
                bodyHeight=elemActualWidth-self.windowWidth+self.windowHeight;

            if (elemActualWidth<=self.windowWidth){
                $body.css('height','auto');
            }else{
                $body.css('height', bodyHeight );
            }
            
            self.docHeight=bodyHeight;
        },
        bindUIActions:function(){
            var self=this;

            $(window).on(self.options.updateEvents,function(){
                self.update();
            });

            $(window).on('scroll', function(e) {
                self.updateScroll($(this).scrollTop());
            });
        },
        update:function(){
            var self=this;
            self.setDimensions();
            self.updateScroll($(window).scrollTop());
        },
        updateScroll:function(currentScrollPos){
            var pos=-1*currentScrollPos,
                cssObj={
                    '-webkit-transform':'translate3d('+pos+'px,0,0)',
                    'transform':'translate3d('+pos+'px,0,0)'
                }
            this.$elem.css(cssObj);
        },
        isTouchDevice:function(){
            var agent = navigator.userAgent.toLowerCase(),
                isChromeDesktop = (agent.indexOf('chrome') > -1 && ((agent.indexOf('windows') > -1) || (agent.indexOf('macintosh') > -1) || (agent.indexOf('linux') > -1)) && agent.indexOf('mobile') < 0 && agent.indexOf('android') < 0);
            return ('ontouchstart' in window && !isChromeDesktop);
        },
        touchDeviceFallback:function(){
            $('body').addClass('invert-scroll-fallback');
        }
    }

    $.fn.olInvertScroll = function( options ) {
        return this.each(function(){
            var olInstance=$.data(this,'olInvertScroll');
            if (typeof olInstance=='object'){
                olInstance.update();
            }else{
                var obj = Object.create( invertScroll ); 
                $.data(this,'olInvertScroll',obj);
                obj.init( options, this );
            }
            
        }); 
    };

    $.fn.olInvertScroll.options = {
        $fixedElem:$('#main-area'),
        updateEvents:'resize isotope-init'
    };
}(jQuery));

