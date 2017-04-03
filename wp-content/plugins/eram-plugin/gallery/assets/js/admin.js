( function( $, window, document ) {
	'use strict';
	var EramBtnHandler = {

		
		init : function(){
			this.cacheElements();
			this.bindUiActions();
		},
		cacheElements: function() {
			this.cache = {
				$body: $( 'body' ),
				$customizerBox : $('.eg-customizer'),
				$goToEditLink: $( '#eg-post-preview' )
			};
		},
		bindUiActions : function(){
			var self = this;
			self.cache.$goToEditLink.on( 'click', function(event) {
				event.preventDefault();
				self.animateLoader();
				wp.autosave.server.triggerSave();
				$( document ).on( 'heartbeat-tick.autosave', function() {
					$( window ).off( 'beforeunload.edit-post' );
					window.location = self.cache.$goToEditLink.attr( 'href' );
				} );
			} );
		},
		animateLoader: function() {
			this.cache.$customizerBox.addClass( 'eram-animate' );
			this.cache.$goToEditLink.addClass('button-disabled');
		}
	};

	$( function() {
		EramBtnHandler.init();
	} );
}( jQuery, window, document ) );