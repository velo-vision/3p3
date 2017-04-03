/*!
 *  Kenburn slider Plugin for JQuery
 *  Version   : 1.2
 *  Date      : 2016-02-02
 *  Licence   : All rights reserved 
 *  Author    : owwwlab (Ehsan Dalvand & Alireza Jahandideh)
 *  Contact   : owwwlab@gmail.com
 *  Web site  : http://themeforest.net/user/owwwlab
 */


(function($, window, document, undefined) {

    var Kenburn = {
        init: function( options , elem ){
            var self = this; 

            self.elem = elem;
            self.$elem = $(elem);
            self.options = $.extend( {}, $.fn.kenburnIt.options, options);

            //Check the mode of plugin
            if (self.options.mode=='markup'){
                self.$elem.find(self.options.itemClass).each(function(i){
                    var imgSrc=$(this).find('img').first().attr('src');
                    self.options.images[i]=imgSrc;

                    var cap = $(this).find(self.options.captionClass);
                    if (cap.attr('data-pos')!==undefined){
                        var pos=cap.attr('data-pos');
                    }
                    else{
                        var pos=0;
                    }

                    self.options.capPositions[i]=pos;
                    self.options.captions[i]= self.prepareCaption(cap);


                    $(this).remove();
                });
            }

            //images list
            self.list = {};
            for (var i = 0; i <= self.options.images.length; i++) {
                self.list[i] = {
                    imgSrc : self.options.images[i],
                    caption : self.options.captions[i],
                    capPositions:self.options.capPositions[i],
                    loaded : false
                }
            };

            //max number of images in the set
            self.maxImg = self.options.images.length;

            if (self.options.preloadNum>self.maxImg-1){
                self.options.preloadNum=self.maxImg-1;
            }

            //set the current slide 
            self.currentSlide = self.options.beginWith ? self.options.beginWith : 0;

            //zoom prefix preset ( 1:zoom-in 0: zoom-out )
            self.zoomPrefix = 1;

            //prepare timing 
            self.calcTime();

            //run
            self.run();

            //Window resize handler
            self.checkSizeFlag=0;
            self.checkSizeChange();
            self.windowResize();

            
        },

        run: function(){
            var self = this;

            //Images
            for (var i = 0; i <= self.options.preloadNum; i++) {
                self.fetchImg(i);
            };

            self.loaderCore(function(){
                self.core();
            });
            

        },
        core:function(){
            var self=this;
            var nextSlideIndex=(self.currentSlide+self.options.preloadNum)%self.options.images.length;
            if (!self.list[nextSlideIndex].loaded){
                self.fetchImg(nextSlideIndex);
            }
            self.setNerOrigin(self.currentSlide);
            self.kbIt();
            self.currentSlide++;
            self.currentSlide = self.currentSlide%self.maxImg;
            self.zoomPrefix = !self.zoomPrefix;

        },

        //animation core
        kbIt: function(){

            var self = this,
                current = self.currentSlide,
                z = self.options.zoom,
                dt = self.timing,
                $slideWrapper=self.list[current].slideWrapper,
                $w1 = self.list[current].wrapper,
                $img1 = self.list[current].img,
                $cap = self.list[current].caption;

            var anim = (new TimelineLite({
                onComplete:function(){
                    self.reset(current);  
                    $slideWrapper.css('z-index','1');
                    $(window).trigger('kbs.slideFinish');
                },
                onStart:function(){
                    $slideWrapper.css('z-index','301');
                    $(window).trigger('kbs.slideStart');
                }
            }));
            
            anim.to($w1, dt.fadeTime, {autoAlpha:1},'start');

            if ( self.zoomPrefix){
                //zoomin
                anim.to($img1, dt.zoomTime, {scale:z, z:0.01, ease: Linear.easeNone},'start');
            }else{
                //zoomout
                anim.from($img1, dt.zoomTime, {scale:z, z:0.01, ease: Linear.easeNone},'start');
            }
            anim.to($cap,dt.captionTime,{autoAlpha:1,ease: Linear.easeNone},'start');
            var captionAnim=self.animateCaption(current);
            if (captionAnim != 'none')
            anim.fromTo($cap,dt.zoomTime,captionAnim.from,captionAnim.to,'start');
            anim.to($w1, dt.fadeTime,{autoAlpha:0}, '-='+dt.fadeTime ,'point');
            anim.to($cap,dt.captionTime,{autoAlpha:0,onComplete:function(){self.core();},ease: Linear.easeNone},'point-='+dt.captionTime*3);
        },

        //caption animation
        animateCaption : function(index){
            var self=this,
                output={};

            var translateX = self.$elem.width()*0.05;
            var pos = self.list[index].capPosition;

            if (pos == 0){
                pos = self.getRand(1,4,1,4);
            }

            if (pos == 'top-left' || pos == 1){
                output={
                  from:{top:'10%',left:'10%',right:'auto',bottom:'auto',x:0,z:0},
                  to:{x:translateX,z:0.01}
                }
            }else if (pos == 'top-right' || pos == 2){
                output={
                  from:{top:'10%',left:'auto',right:'10%',bottom:'auto',x:0,z:0},
                  to:{x:-translateX,z:0.01}
                }
            }else if (pos == 'bottom-left' || pos == 3){
                output={
                  from:{top:'auto',left:'10%',right:'auto',bottom:'10%',x:0,z:0},
                  to:{x:translateX,z:0.01}
                }
            }else if(pos == 'none'){
                output = pos;
            }
            else{
                output={
                  from:{top:'auto',left:'auto',right:'10%',bottom:'10%',x:0,z:0},
                  to:{x:-translateX,z:0.01}
                }
            }   
            
            return output
        },

        //injection core
        fetchImg: function(index){
            
            var self = this,
                imgSrc = self.list[index].imgSrc,
                captionHtml = self.list[index].caption,
                capPosition=self.list[index].capPositions;
            
            var wrapper = $("<div/>");
            wrapper.attr('class','owl-slide');

            var img = $("<img />");
            img.attr('src', imgSrc);
            img.attr('alt', 'img');
            var owlImg = $("<div/>").attr('class','owl-img').html(img);
            owlImg.css({'opacity':0,'visibility':'hidden'}).appendTo(wrapper);

            var caption = $("<div/>");
            caption.attr('class','owl-caption');
            caption.html(captionHtml);
            caption.appendTo(wrapper);
            
            //inject into DOM
            self.$elem.append(wrapper);

            self.list[index] = {
                slideWrapper:wrapper,
                wrapper : owlImg,
                img : img,
                caption : caption,
                capPosition:capPosition,
                loaded : true
            };
            img.on('load',function(){
                self.imageFill(index);
            });
        },

        //handles size of images to fit the context
        imageFill :function(index,inputImg){
            var self=this,
                img=self.list[index].img,
                containerWidth=self.$elem.width(),
                containerHeight=self.$elem.height(),
                containerRatio=containerWidth/containerHeight,
                imgRatio;
            if(inputImg!=undefined){
                img=inputImg;
            }
            imgRatio=img.width()/img.height();
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
        },

        checkSizeChange:function() {
          var self=this;
          if (self.checkSizeFlag) {
            self.checkSizeFlag=0;
            self.$elem.find('img').each(function(){
                self.imageFill(0,$(this));
            })
          }
          setTimeout(function(){
            self.checkSizeChange();
          }, 200);
        },

        windowResize :function(){
            var self=this;
            $(window).resize(function(){
                self.checkSizeFlag=1;
            });
            
        },

        reset : function(index){
            TweenMax.to(this.list[index].img, 0,{scaleY:1,scaleX:1});
        },

        calcTime: function(){
            
            var time = this.options.duration;
            
            this.timing = {
                fadeTime            : time/5,
                zoomTime            : time,
                captionTime         : time/10,
                iterate             : time-time/5
            }
        },

        prepare: function(){

        },

        prepareCaption: function($cap){
            var $parts=$cap.text().split('|');
            if ($parts.length<=1)
                return $cap;

            
            var $title=$cap.find('.title');
            $title.html('');
            $.each($parts,function(index,val){
                $('<span>').text(val).appendTo($title);
            });

            return $cap;
        },

        setNerOrigin: function(index){
            var x=0,y= 0;
            
            x = this.getRand(0,25,75,100);
            y = this.getRand(0,25,75,100);
            var css = {
                "-moz-transform-origin"     : x+"% "+y+"%",
                "-webkit-transform-origin"  : x+"% "+y+"%",
                "-o-transform-origin"       : x+"% "+y+"%",
                "-ms-transform-origin"      : x+"% "+y+"%",
                "transform-origin"          : x+"% "+y+"%"
            };
            this.list[index].img.css(css);
        },

        getRand : function (min1, max1, min2, max2) {
            var ret = 0;
            var dec = (Math.random()<0.5)? 0 :1;
            if ( dec==1){
                ret = parseInt(Math.random() * (max1-min1+1), 10) + min1;    
            }else{
                ret = parseInt(Math.random() * (max2-min2+1), 10) + min2;    
            }
            return ret;
            
        },

        loaderCore:function(callback){
            var self=this;

            var $loaderElem=self.$elem.find('.kb-loader');
           self.$elem.imagesLoaded(function(){
                $loaderElem.fadeOut();
                callback();
           });

        }

    }

    
    $.fn.kenburnIt = function( options ) {
        return this.each(function(){
            var kenburn = Object.create( Kenburn ); //our instance of Kenburn
            kenburn.init( options, this );
        }); 
    };

    $.fn.kenburnIt.options = {
        images : [],
        captions :[],
        capPositions:[],
        zoom : 1.1,
        duration : 8,
        mode: 'markup',//either markup or object
        itemClass: '.item',
        captionClass : '.caption',
        preloadNum:2,
        onLoadingComplete:function(){},
        onSlideComplete:function(){},
        onListComplete:function(){},
        getSlideIndex:function(){
            return currentSlide;
        }
    };

})(jQuery, window, document);