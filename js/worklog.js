(function($) {

	/**
	 * WorkLog namespace.
	 */
	WorkLog = {

		// The active entry.
		activeEntry: null,

		/**
		 * Entry object.
		 * @param Array data the entry data.
		 */
		Entry: function(data) {
			this.id = data.id;
			this.ownerId = data.ownerId;
			this.activityId = data.activityId;
			this.comment = data.comment;
			this.startDate = data.startDate;
			this.endDate = data.endDate;
			this.state = data.state;
		},

		/**
		 * Returns the active entry.
		 * @return WorkLog.Entry the entry.
		 */
		getActiveEntry: function() {
			return WorkLog.activeEntry;
		},

		/**
		 * Updates the active entry.
		 */
		updateActiveEntry: function() {
			var seconds = WorkLog.getSecondsSince(WorkLog.activeEntry.startDate);
			var time = WorkLog.formatTime(seconds);
			$('#entryDuration').html(time);
		},

		/**
		 * Updates the application clock.
		 */
		updateClock: function() {
			var now = new Date();
			var hours = now.getUTCHours().toString().str_pad_left(2, '0');
			var minutes = now.getUTCMinutes().toString().str_pad_left(2, '0');
			var seconds = now.getUTCSeconds().toString().str_pad_left(2, '0');
			var time = hours + ':' + minutes + ':' + seconds;
			$('#clock').html(time);
		},

		/**
		 * Returns the amount of seconds since the given timestamp.
		 * @param Number timestamp the timestamp.
		 * @return Number seconds since.
		 */
		getSecondsSince: function(timestamp) {
			var now = Math.round(new Date().getTime() / 1000);
			return now - timestamp;
		},

		/**
		 * Formats seconds as hours, minutes and seconds.
		 * @param Number seconds the seconds.
		 * @return String the formatted time.
		 */
		formatTime: function(seconds) {
			var minutes = 0, hours = 0;
			var string = '';

			minutes = seconds>60 ? Math.floor(seconds/60) : '< 1';

			if( minutes>60 ) {
				hours = Math.floor(minutes/60);
				minutes = minutes % 60;
			}

			// Append the hours if necessary.
			if( hours>0 ) {
				string += hours + ' h ';
			}

			// Append the minutes.
			string += minutes + ' min ';

			return string;
		}
	};

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
	}

	/**
	 * Actions to be taken when the window is ready.
	 */
	$(window).ready(function() {

		// Update the application clock every second.
		setInterval(WorkLog.updateClock, 1000);

		// Update the active entry if visible on the page.
		$entryDuration = $('#entryDuration');
		if( $entryDuration.length>0 ) {
			setInterval(WorkLog.updateActiveEntry, 1000);
		}

	});

})(jQuery);