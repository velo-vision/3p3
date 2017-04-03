/*!
 *  Rail Carousel Plugin for JQuery
 *  Version   : 1.0
 *  Date      : 2016-11-08
 *  Licence   : All rights reserved 
 *  Author    : owwwlab (Ehsan Dalvand & Alireza Jahandideh)
 *  Contact   : owwwlab@gmail.com
 *  Web site  : http://themeforest.net/user/owwwlab
 */


(function($, window, document, undefined) {
    
    var railCarousel = {
        init: function( options , elem ){
            var self = this; 

            self.elem = elem;
            self.$elem = $(elem);
            self.options = $.extend( {}, $.fn.olRailCarousel.options, options);
            self.videoBg();
            self.setRequirments();
            self.setVariables();
            
            self.loaderCore(function(){
                self.prepare();
                self.initDependencies();
                self.bindUIActions();
            });
            
        },
        setRequirments:function(){
            var self=this;

            self.$window=$(window);
            self.$rail=self.$elem.find('.nav-rail');
            self.$swiperContainer=self.$elem.find('.swiper-container');
            self.$counter=self.$rail.find('.counter-wrapper');
            self.$counterCurrent=self.$counter.find('.current');
            self.$swiperWrapper=self.$elem.find('.swiper-wrapper');
            self.$slides=self.$elem.find('.swiper-slide');
            self.$slideDetails=self.$elem.find('.slide-details');
            self.$mustLoadImages=self.$elem.find('img.media-elem');
            self.$slides.each(function(){
                var $this=$(this),
                    slideAtts={};
               
                slideAtts.mediaType=$this.data('media-type');
                slideAtts.$description=$this.find('.description');
                slideAtts.$detailsWrapper=$this.find('.slide-details');
                slideAtts.$parallaxShine=$this.find('.shine');


                if (slideAtts.mediaType=='video'){
                    var $videoBG=$this.find('.owl-videobg'),
                        $video=$videoBG.find('video');

                    if ($video.length){
                        slideAtts.$media=$video;
                    }else{
                        // fallback to image mode for mobile device or in case the video file is not provided somehow
                        slideAtts.mediaType='image';
                        slideAtts.$media=$videoBG;
                    }

                    var poster=$videoBG.data('poster'),
                        $posterImg;

                    if (poster != undefined){
                        $posterImg=$('<img>').attr('src', poster );
                        self.$mustLoadImages=self.$mustLoadImages.add($posterImg);
                    }
                    slideAtts.$bgImg=$posterImg;


                    
                }else{
                    slideAtts.$media=$this.find('img.slide-image');
                    slideAtts.$bgImg=slideAtts.$media;
                }

                if ($this.data('bg-image')){
                    var $tempImg=$('<img>').attr('src', $this.data('bg-image') );
                    self.$mustLoadImages=self.$mustLoadImages.add($tempImg);
                    slideAtts.$bgImg=$tempImg;
                }


                $this.data('slideAtts',slideAtts);
            });
            self.$currentSlide=self.$slides.eq(0);
            self.$prevSlide=$();
            self.slidesCount=self.$slides.length;
            self.railCurrent=1;
           if (self.options.dynamicBackgroundImage){
                self.$dynamicBgImg=self.$elem.find('.dynamic-bg-image');
                self.$bgImages=self.$dynamicBgImg.children('div');
           }
            
        },
        setVariables:function(){
            var self=this;
            self.railsTop = self.$rail.offset().top;
            self.railsHeight = self.$rail.outerHeight();
            self.elemHeight = self.$elem.height();
            self.totalHeight = self.slidesCount * self.elemHeight;
            self.wHeight=self.$window.height();
            self.wWidth=self.$window.width();
        },
        prepare:function(){
            var self=this;
            self.$counter.find('.total').text(self.slidesCount);
            self.$counterCurrent.text(self.railCurrent);
            self.$elem.find('.slide-media').each(function(){
                imageFill($(this));
            });

            //Set slides background color
            if (self.options.dynamicBackground){
                var defaultBGColor=self.$elem.css('background-color');
                self.$slides.each(function(){
                    var $this=$(this),
                        slideAtts=$this.data('slideAtts');

                    slideAtts.bgColor=slideAtts.$bgImg?self.extractImageColor(slideAtts.$bgImg):defaultBGColor;
                    $this.data('slideAtts',slideAtts);
                });
            }

            //Set slides background image
            if (self.options.dynamicBackgroundImage){
                self.$bgImages.css('background-image','url('+self.$currentSlide.data('slideAtts').$bgImg.attr('src')+')');
                
            }
        },
        initDependencies:function(){
            var self=this;
            self.slider = new Swiper ('.swiper-container', {
                direction: 'vertical',
                touchEventsTarget:'none',
                spaceBetween: 0,
                keyboardControl:true,
                virtualTranslate:false,
                speed: 1000,
                simulateTouch:false,
                mousewheelControl: true,
                mousewheelForceToAxis: true,
                mousewheelInvert: true,
                touchMoveStopPropagation:false,
                onlyExternal:true,
                onSlideChangeStart:function(swiper){
                    self.changeSlide('start');
                    
                },
                onSlideChangeEnd:function(swiper){
                    self.changeSlide('end');
                },
                onInit:function(swiper){
                    self.animateCarouselBg(self.$currentSlide);
                    self.controlVideo(self.slider,true);
                    
                }
            });

            self.slider.disableTouchControl();

            self.$draggable = self.$counter.draggabilly({
                axis: 'y',
                containment: '.nav-rail'
            });
        },
        bindUIActions:function(){
            var self=this;
           
            self.$draggable.on( 'pointerDown' , function(){
                self.railEnter();
            });
            self.$draggable.on( 'pointerUp' , function(){
                self.railExit();
            });
            self.$draggable.on( 'dragMove', function() {
                self.railMove();
            });  

            if (self.options.enableParallax){
                 self.$elem.on('mousemove','.swiper-slide',function(event) {
                    self.parallaxHandler();
                 });
            }
            self.$window.on('resize',function(){
                self.setVariables();
            });

            if (self.olIsTouchDevice()){
                self.$elem.swipe({
                    swipe:function(event, direction, distance) {
                        if (direction=='up'){
                          self.slider.slideNext();
                        }else if (direction=='down'){
                          self.slider.slidePrev();
                        }
                    }
                });

                self.$elem.on('touchmove',function(e){
                    e.preventDefault();
                });
            }
        },
        railEnter:function(){
            var self=this,
                slidesWrapperY = -self.slider.realIndex * self.elemHeight;

            self.$swiperWrapper.addClass('rail-mode');
            self.$rail.addClass('grab');
            $.og.$body.addClass('rail-grab');

            TweenMax.fromTo(self.$swiperWrapper,0.5, {scale:1,z:0.01,y:slidesWrapperY}, {scale:self.options.railZoom,z:0.01,y:slidesWrapperY*self.options.railZoom,ease: Power1.easeOut});
            self.$slideDetails.css('width',400);
        },
        railExit:function(){
            var self=this,
                slidesWrapperY = -self.slider.realIndex * self.elemHeight;
            
            self.$swiperWrapper.removeClass('rail-mode');
            self.$rail.removeClass('grab');
            $.og.$body.removeClass('rail-grab');

            TweenMax.to(self.$swiperWrapper,0.5, {scale:1,z:0.01,y:slidesWrapperY,ease: Back.easeOut});
            self.slider.slideTo(self.slider.realIndex,0,false);
            self.changeSlide('rail');
        },
        railMove:function(){
            var self=this,
                railPercent=self.$draggable.data('draggabilly').position.y / (self.railsHeight),
                slidePosition = self.totalHeight * railPercent,
                InViewSlide= Math.round(slidePosition/self.elemHeight);

            var railCurrentSlide=Math.min(Math.round(railPercent/(1/self.slidesCount))+1,self.slidesCount);

            if (railCurrentSlide!=self.railCurrent){
                self.railCurrent=railCurrentSlide;
                self.updateCounter(railCurrentSlide);
            }
            self.slider.realIndex = InViewSlide;
            TweenMax.to(self.$swiperWrapper,0.5,{y:-slidePosition*self.options.railZoom});
        },
        changeSlide:function(mode){
            var self=this,
                $currentSlide=self.$currentSlide=self.$slides.eq(self.slider.realIndex),
                $prevSlide=self.$prevSlide=self.$slides.eq(self.slider.previousIndex);

            if(mode=='start'){
                $currentSlide.removeClass('slide-out').addClass('slide-in');
                $prevSlide.addClass('slide-out');
                self.animateSlide($prevSlide,'Out');
                self.animateSlide($currentSlide,'In');
                self.animateCounter()
                self.animateCarouselBg($currentSlide);
                self.animateBgImage($currentSlide);
                self.updateCounter();
                self.controlVideo(self.slider);
                self.railCurrent=self.slider.realIndex;
            }
            else if(mode=='rail'){
                self.animateCounter();
                self.animateCarouselBg($currentSlide);
                self.animateBgImage($currentSlide);
                self.controlVideo(self.slider);
                self.animateSlide($currentSlide,'Rail-In');
            }
            else{
                $prevSlide.removeClass('slide-in');
                self.animateSlide($prevSlide,'In');
            }
        },
        animateCounter:function(){
            var self=this,
                counterY=self.slider.realIndex * ( (self.railsHeight-100 )/ (self.slidesCount-1) );

            TweenMax.to(self.$counter,1,{top:counterY,ease: Power4.easeInOut});
        },
        animateSlide:function($slide,mode){
            var self=this,
                slideAtts=$slide.data('slideAtts');

            if (mode=="In"){
                TweenMax.fromTo(slideAtts.$media, 1, {scale:1.3,z:0.01}, {scale:1,z:0.01,ease: Power2.easeInOut} );
                TweenMax.fromTo(slideAtts.$description, 1, {opacity:0,y:40}, {opacity:1,y:30,ease: Power4.easeInOut} ).delay(0.5);
                TweenMax.fromTo(slideAtts.$detailsWrapper, 1, {width:0}, {width:400,ease: Power4.easeInOut} ).delay(0.5);

            }else if (mode == "Out"){
                TweenMax.fromTo(slideAtts.$detailsWrapper, 1, {width:400}, {width:0,ease: Power4.easeOut} );
                TweenMax.fromTo(slideAtts.$media, 1, {scale:1,z:0.01}, {scale:1.3,z:0.01,ease: Power2.easeInOut} );
                TweenMax.fromTo(slideAtts.$description, 0.5, {opacity:1,y:30}, {opacity:0,y:40,ease: Power4.easeInOut} );

            }else if (mode == "Rail-In"){
                TweenMax.fromTo(slideAtts.$description, 1, {opacity:0,y:40}, {opacity:1,y:30,ease: Power4.easeInOut} );
            }
        },
        animateCarouselBg:function($slide){
            var self=this,
                bgColor=$slide.data('slideAtts').bgColor;
            if (self.options.dynamicBackground){
                self.$elem.velocity({backgroundColor:bgColor});
                self.$counter.velocity({backgroundColor:bgColor});
            }
        },
        animateBgImage:function($slide){
            var self=this;

             if (!self.options.dynamicBackgroundImage)
                return false;

            var $inImage=self.$bgImages.filter('.in'),
                $outImage=self.$bgImages.filter('.out');

            $outImage.css('background-image','url('+$slide.data('slideAtts').$bgImg.attr('src')+')');
            $inImage.removeClass('in').addClass('out');
            $outImage.removeClass('out').addClass('in');
        },
        extractImageColor:function($img){
            var self=this,
                vibrant = new Vibrant($img[0], 48, 5), 
                swatches = vibrant.swatches();

            return swatches.Muted.getHex();
        },
        controlVideo:function(swiper,initFlag){
            var self = this,
                prevSlideAtts=self.$prevSlide.data('slideAtts'),
                currentSlideAtts=self.$currentSlide.data('slideAtts');

            //pause previous video
            if (!initFlag){
                 if (prevSlideAtts.mediaType=='video'){
                    prevSlideAtts.$media[0].pause();
                }
            }
            if (currentSlideAtts.mediaType=='video'){
                currentSlideAtts.$media[0].play();
            }
        },
        parallaxHandler:function(){
            var self = this,

                cx = Math.ceil(self.wWidth / 2),
                cy = Math.ceil(self.wHeight / 2),
                dx = event.pageX - cx,
                dy = event.pageY - cy,
                tiltx = (dy / cy),
                tilty = - (dx / cx),
                radius = Math.sqrt(Math.pow(tiltx,2) + Math.pow(tilty,2)),
                degree = (radius *5),
                theta = Math.atan2(dy, dx), //angle between cursor and center of poster in RAD
                angle = theta * 180 / Math.PI - 90; //convert rad in degrees
                //get angle between 0-360
                if (angle < 0) {
                    angle = angle + 360;
                }

                self.$currentSlide.css('transform','rotate3d(' + tiltx + ', ' + tilty + ', 0, ' + degree + 'deg)');
                self.$currentSlide.data('slideAtts').$parallaxShine.css('background', 'linear-gradient(' + angle + 'deg, rgba(255,255,255,' + event.pageY / self.wHeight * .15 + ') 0%,rgba(255,255,255,0) 70%)');
        },
        videoBg:function(){
            var self=this,
                $videoBg=self.$elem.find('.owl-videobg');
            $videoBg.owlVideoBg({
                preload:'auto',
                muted: $videoBg.data('mute')=='yes'
            });
        },
        updateCounter:function(index){
            var self=this,
                index=index?index:self.slider.realIndex+1;

            self.$counterCurrent.text(index);
        },
        loaderCore:function(callback){
            var self=this;

            var $loaderElem=self.$elem.find('.rail-carousel-loader');
            self.$mustLoadImages.imagesLoaded(function(){
                TweenMax.to($loaderElem.find('.spinner'),0.5,{opacity:0});
                TweenMax.to($loaderElem,1,{height:0,ease:Power4.easeIn});
                callback();
            });
        },
        //Check for Touch devices
        olIsTouchDevice:function(){
            var agent = navigator.userAgent.toLowerCase(),
                isChromeDesktop = (agent.indexOf('chrome') > -1 && ((agent.indexOf('windows') > -1) || (agent.indexOf('macintosh') > -1) || (agent.indexOf('linux') > -1)) && agent.indexOf('mobile') < 0 && agent.indexOf('android') < 0);
            return ('ontouchstart' in window && !isChromeDesktop);
        }
    }

 /* cover images in a container
    ----------------------------------------------*/
    function imageFill($container,callback){

        setFillCSS($container,callback);

        $(window).on('debouncedresize',function(){
            setFillCSS($container,callback);
        });
    } 

    function setFillCSS($container,callback){
        var containerWidth=$container.width(),
        containerHeight=$container.height(),
        containerRatio=containerWidth/containerHeight,
        imgRatio;

          $container.find('img').each(function(){
            var img=$(this);
            imgRatio=parseInt(img.attr('width'))/parseInt(img.attr('height'));
            
            if (img.css('position')=='static'){
                img.css('position','relative');
            }
            if (containerRatio < imgRatio) {
              // taller
              img.css({
                  width: 'auto',
                  height: containerHeight,
                  top:0,
                  left:-(containerHeight*imgRatio-containerWidth)/2
                });
            } else {
              // wider
              img.css({
                  width: containerWidth,
                  height: 'auto',
                  top:-(containerWidth/imgRatio-containerHeight)/2,
                  left:0
                });
            }
          });

      if (typeof(callback) == 'function'){
        callback();
      }
    }

    
    $.fn.olRailCarousel = function( options ) {
        return this.each(function(){
            var carouselObj = Object.create( railCarousel ); //our instance of Kenburn
            carouselObj.init( options, this );
        }); 
    };

    $.fn.olRailCarousel.options = {
        railZoom:0.6,
        dynamicBackground:true,
        dynamicBackgroundImage:true,
        enableParallax:true,
    };

})(jQuery, window, document);