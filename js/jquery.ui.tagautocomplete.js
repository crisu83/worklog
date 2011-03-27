(function( $, undefined ) {

$.widget( 'ui.tagautocomplete', {

	options: {
		value: null,
		source: null, 
		autocompleteOptions: {},
		name: ''
	},

	_create: function() {
		var self = this;

		this.name = this.element.attr( 'name' ) || this.options.name;
		this.originalWidth = this.element.width();

		// wrap the input with a div
		this.element.wrap( '<div></div>' );
		this.container = this.element.parent().addClass( 'ui-tag-autocomplete' );

		// create a list which will work as a ui for the tags
		this.presentation = $( '<ul></ul>' ).addClass( 'ui-tag-presentation' );
		this.container.append(this.presentation);

		this._initPresentation();

		// bind the key handler function into the element's key down event
		this.element.bind( 'keydown', function( event ) {
			var ac = $( this ).data( 'newitemcomplete' );

			// do not let the field blur if the auto complete list is open and were pushing TAB
			switch( event.keyCode ) {
				case $.ui.keyCode.TAB:
					if( ac.menu.element.is( ':visible' ) === true ) {
						if( ac.menu.active === undefined ) {
							// TODO: get the first item from the list
						}

						event.preventDefault();
					}
				break;
				case $.ui.keyCode.BACKSPACE:
					if( $( ac.element ).val() === '' ) {
						self.presentation.children( 'li:last' ).remove();
						self._updateInput();
					}
				break;
			}
		});

		this.element.newitemcomplete( $.extend(this.options.autocompleteOptions, {
			source: function( request, response ) {
				$.ajax({
					url: self.options.source,
					data: { term: request.term },
					dataType: 'json',
					success: function(data) {
						var value = self.element.val();

						if ( !data ) {
							data = [];
						}

						if ( data.length===0 || self._hasDirectMatch(data, value) === false ) {
							data.push( { label: value, value: value, newItem: true } );
						}

						response(data);
					}
				});
			},
			select: function( event, ui ) {
				var tagLabel = ui.item.newItem === true ? this.value : ui.item.value;
				var item = self._createTagPresentation( tagLabel );
				
				// append a new item to presentation
				self.presentation.append( item );

				// update the padding of the input, so that the text appears next to the presentation
				self._updateInput();

				// clear the input
				this.value = '';

				return false;
			},
			focus: function() {
				// prevent value inserted on focus
				return false;
			}
		}));
	},

	_updateInput: function() {
		var leftPadding = this.presentation.width() + 2;
		var rightPadding = this.element.css( 'padding-right' );
		rightPadding = parseInt( rightPadding.substr( 0, rightPadding.length - 2 ), 10 );

		var width = ( this.originalWidth + rightPadding ) - leftPadding;
		this.element.css( 'padding-left', leftPadding + 'px' );

		this.element.width( width > 0 ? width : 0 );
	},

	_createTagPresentation: function( label, value ) {
		if ( !value ) {
			value = label;
		}

		var self = this;
		var removeButton = $( '<div class="remove-button">x</div>' ).bind( 'click', function() {
			$( this ).parent().remove();
			self._updateInput();
		});
		var element = $( '<li><span class="label">'+label+'</span></li>' );
		element.append( removeButton );

		if ( self.name ) {
			var input = $( '<input />').attr( 'type', 'hidden' ).attr( 'name', this.name+'[]' ).val( value );
			element.append( input );
		}

		return element;
	},

	// TODO add support for value objects like in autocomplete, so that you can define label and value separately
	_initPresentation: function() {
		if ( !this.options.value ) {
			return false;
		}

		var valueList = [];
		if ( jQuery.isArray(this.options.value) === false ) {
			valueList.push(this.options.value);
		}
		else {
			valueList = this.options.value;
		}

		var self = this;
		$.each( valueList, function( i, value ) {
			self.presentation.append( self._createTagPresentation( value ) );
		});

		self._updateInput();
	},

	_hasDirectMatch: function(valueList, term) {
		for ( var i = 0, length = valueList.length; i < length; i++ ) {
			if ( valueList[ i ] == term ) {
				return true;
			}
		}

		return false;
	}
});
	
}(jQuery));

(function( $, undefined ) {

$.widget('custom.newitemcomplete', $.ui.autocomplete, {
	_renderItem: function( ul, item) {

		// add support for the new item menu item
		if( item.newItem ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.addClass('ui-tag-autocomplete-newitem')
				.prepend( $( "<a></a>" ).html( item.value + ' <span>(New tag)</span>' ) )
				.appendTo( ul );
		}

		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( $( "<a></a>" ).text( item.label ) )
			.appendTo( ul );
	}
});

}(jQuery));