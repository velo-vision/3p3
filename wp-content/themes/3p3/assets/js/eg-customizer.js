(function( api, $ ) {

    'use strict';


    var galleryArchiveNavigationLink={
        init:function($section){

            this.$section = $section;
            this.$section.$title = $section.find( '.customize-section-title:first' );

            this.appendToDom();
            this._init();
            this.setParams();
            this.bindUIActions();
        },
        _init:function () {

        },
        bindUIActions:function(){
            var self = this;

            self.$section.on( 'click eg_selector_change','.__eg_preview', function( event ) {
                event.preventDefault();
                self.setParams();
                var newUrl = self.getPreviewUrl( self.params );
                api.previewer.previewUrl( newUrl );

            } );
        },
        setParams:function () {
            this.params={};
            this.params.post_type='eramgallery';
        },
        appendToDom: function () {
            var self = this;
            self.$previewButton =
                $('<button title="'+ egGal.btnTitle +'" class="__eg_preview customize-posts-navigation dashicons dashicons-visibility"></button>')
                .appendTo(self.$section.$title);

        },
        getPreviewUrl:function ( params ) {
            var url = api.settings.url.home;

            if ( ! params  ) {
                throw new Error( 'Missing params' );
            }

            params.preview = true;

            var redirect =  url + '?' + $.param( params );

            // console.log(redirect);
            return redirect;

        }
    };

    var portfolioArchiveNavigationLink = Object.create( galleryArchiveNavigationLink );
    portfolioArchiveNavigationLink.setParams=function(){
        this.params={};
        this.params.post_type='eramfolio';
    };


    var galleryCategoryNavigationLink=Object.create( galleryArchiveNavigationLink );
    galleryCategoryNavigationLink.setParams=function(){
        var value = this.$selector.val();
        this.params={};

        if ( value != 0 ) {
            this.params.egcategory = value;
        }
    };
    galleryCategoryNavigationLink._init=function(){
        var self=this;
        self.$selector=$('#customize-control-eg_categories select');
        self.handlePreviewTrigger();
        self.$selector.on('change',function(){
            self.handlePreviewTrigger();
        });
    };
    galleryCategoryNavigationLink.handlePreviewTrigger=function(){
        var self=this;

        if (self.$selector.val()==0){
            self.$previewButton.removeClass('visible');
        }else{
            self.$previewButton.addClass('visible').trigger('eg_selector_change');
        }
    };


    var portfolioCategoryNavigationLink =  Object.create( galleryArchiveNavigationLink );
    portfolioCategoryNavigationLink.setParams=function(){
        var value = this.$selector.val();
        this.params={};
        if ( value != 0 ) {
            this.params.efcategory = value;
        }
    };
    portfolioCategoryNavigationLink._init=function(){
        var self=this;
        self.$selector=$('#customize-control-epf_categories select');
        self.handlePreviewTrigger();
        self.$selector.on('change',function(){
            self.handlePreviewTrigger();
        });
    };
    portfolioCategoryNavigationLink.handlePreviewTrigger=function(){
        var self=this;

        if (self.$selector.val()==0){
            self.$previewButton.removeClass('visible');
        }else{
            self.$previewButton.addClass('visible').trigger('eg_selector_change');
        }
    };

    
    var galleryCategoryShowHideControls={
        init:function($selector){
            this._init($selector);
            this.bindUIActions();
        },
        _init:function($selector) {
            this.$selector=$selector;
            this.allControlElems=$("#sub-accordion-section-eg_categories").find('li.customize-control');
            console.log(this.$selector);
        },
        bindUIActions:function () {
            var self=this;
            self.$selector.on('change',function () {
                var $this=$(this),
                   catSlug=$this.val();

                self.allControlElems.removeClass('visible').filter(function(){
                   var ret=false,
                       $this=$(this);

                   if ($this.attr('id')){
                       ret=($this.attr('id').indexOf('_'+catSlug+'_')>0)?true:false;
                   }

                   return ret;
                }).addClass('visible');

            });
        }
    }

    var portfolioCategoryShowHideControls = Object.create( galleryCategoryShowHideControls );
    portfolioCategoryShowHideControls._init=function($selector){
        this.$selector=$selector;
        this.allControlElems=$("#sub-accordion-section-epf_categories").find('li.customize-control');
    };

    //*********** Init Handler for all Functions *******//
    var initRequired={
        init:function(){
            $.og={
                $body:$('body'),
                $header:$('#header'),
                $window:$(window)
            };

            this.runMethods();
            this.runInlines();
        },
        runMethods:function(){
            createObjInstance('#sub-accordion-section-eg_archive',galleryArchiveNavigationLink);
            createObjInstance('#sub-accordion-section-epf_archive',portfolioArchiveNavigationLink);
            createObjInstance('#sub-accordion-section-eg_categories',galleryCategoryNavigationLink);
            createObjInstance('#sub-accordion-section-epf_categories',portfolioCategoryNavigationLink);
            createObjInstance('#sub-accordion-section-eg_categories #customize-control-eg_categories select', galleryCategoryShowHideControls);
            createObjInstance('#sub-accordion-section-epf_categories #customize-control-epf_categories select', portfolioCategoryShowHideControls);
        },
        runInlines:function(){

        }
    };
    //*********** Init Handler for all Functions *******//

    //Run methods on DOM Ready
    $(document).ready(function(){
        initRequired.init();
    });

    //Run methods on Window load
    $(window).on('load',function(){

    });

    /* Create Object Instance
     ----------------------------------------------*/
    function createObjInstance(selector,objName,options){
        $(selector).each(function(){
            var obj = Object.create( objName );
            obj.init($(this),options);

        });
    }

})( wp.customize, jQuery );

