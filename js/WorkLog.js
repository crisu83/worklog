(function() {

	/**
	 * Pads this string with the 'pad' character
	 * until the given length is reached.
	 * @param Number length the length.
	 * @param String pad the character to pad with.
	 * @return the padded string.
	 */
	String.prototype.str_pad_left = function(length, pad) {
		var string = this;

		while( string.length<length )
			string = pad + string;

		return string;
	};

})();