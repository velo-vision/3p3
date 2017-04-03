/*!
 *  Custom dropdown for JQuery
 *  Version   : 1.0
 *  Date      : 2017-02-24
 *  Licence   : All rights reserved 
 *  Author    : owwwlab (Ehsan Dalvand & Alireza Jahandideh)
 *  Contact   : owwwlab@gmail.com
 *  Web site  : http://themeforest.net/user/owwwlab
 */
;( function( $, window, undefined ) {

	'use strict';

	var olDropdown = {

		init : function( options,elem ) {

			this.$el = $(elem);
			// options
			this.options = $.extend( true, {}, $.fn.olDropdown.options, options );
			this.layout();
			this.bindEvents();

		},
		layout : function() {

			this.transformSelect();
			this.opts=this.listopts.children( 'li' );
			this.$el.css('display','none');
		},
		transformSelect : function() {

			var optshtml = '', selectlabel = '', value = -1, oldVal = this.$el.val();
			this.$el.children( 'option' ).each( function() {

				var $this = $( this ),
					val = isNaN( $this.attr( 'value' ) ) ? $this.attr( 'value' ) : Number( $this.attr( 'value' ) ) ,
					classes = $this.attr( 'class' ),
					selected = $this.attr( 'selected' ) || oldVal == val,
					label = $this.text();

				if( val !== -1 ) {
					optshtml += 
						classes !== undefined ? 
							'<li data-value="' + val + '"><span class="' + classes + '">' + label + '</span></li>' :
							'<li data-value="' + val + '"><span>' + label + '</span></li>';
				}

				if( selected ) {
					selectlabel = label;
					value = val;
				}

			} );

			this.listopts = $( '<ul/>' ).addClass('ol-select-list').append( optshtml );
			this.selectlabel = $( '<span/>' ).addClass('select-holder').append( selectlabel );
			this.dd = $( '<div class="ol-dropdown"/>' ).append( this.selectlabel, this.listopts ).insertAfter( this.$el );

		},
		bindEvents : function() {
			
			var self = this;
			
			this.selectlabel.on( 'mousedown.dropdown', function( event ) {
				self.opened ? self.close() : self.open();
				return false;

			} );

			this.opts.on( 'click.dropdown', function() {
				if( self.opened ) {
					var opt = $( this );
					var val = opt.data( 'value' );
					self.options.onOptionSelect( opt );
					if (val != self.$el.val()) {
						self.$el.val( val );
						self.$el.change();
					}
					self.selectlabel.html( opt.html() );
					self.close();
				}
			} );

		},
		open : function() {
			var self = this;
			this.dd.toggleClass( 'is-active' );
			this.listopts.stop(0,0).slideDown(150);
			this.opened = true;

		},
		close : function() {

			var self = this;
			this.dd.toggleClass( 'is-active' );
			this.listopts.stop(0,0).slideUp(100);
			this.opened = false;

		}

	}

	$.fn.olDropdown = function( options ) {
		return this.each(function(){
            var obj = Object.create( olDropdown );
            obj.init( options, this );
        }); 
	};

	// options
	$.fn.olDropdown.options = {
		onOptionSelect : function(opt) { return false; }
	};

} )( jQuery, window );
