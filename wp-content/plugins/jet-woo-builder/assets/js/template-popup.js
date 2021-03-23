(function( $ ) {

	'use strict';

	var JetWooTemplatePopup = {

		init: function() {

			var self = this;

			$( document )
				.on( 'click.JetWooTemplatePopup', '.jet-woo-new-template', self.openPopup )
				.on( 'click.JetWooTemplatePopup', '.jet-template-popup__overlay', self.closePopup );

			if ( $( '.wp-header-end' ).length ) {
				$( '.wp-header-end' ).before( JetWooPopupSettings.button );
			}

		},

		openPopup: function( event ) {
			event.preventDefault();
			$( '.jet-template-popup' ).addClass( 'jet-template-popup-active' );
		},

		closePopup: function() {
			$( '.jet-template-popup' ).removeClass( 'jet-template-popup-active' );
		}

	};

	JetWooTemplatePopup.init();

})( jQuery );