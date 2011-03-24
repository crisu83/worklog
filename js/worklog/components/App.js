/**
 * Application component.
 * @class WorkLog.component.App
 */
WorkLog.component.App = {

	activeEntryData: null,

	/**
	 * Runs the application.
	 */
	run: function() {
		// Update the application clock every second.
		setInterval(this.updateClock, 1000);

		if( $('#entryDuration').length>0 ) {
			setInterval(WorkLog.updateActiveEntry, 1000);
		}
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
	 * Sets the data for the active entry.
	 * @param {Object} data
	 */
	setActiveEntryData: function(data) {
		this.activeEntryData = data;
	},

	/**
	 * Updates the active entry.
	 */
	updateActiveEntry: function() {
		var seconds = this.getSecondsSince(this.activeEntryData.startDate);
		var time = this.formatTime(seconds);
		$('#entryDuration').html(time);
	},

	/**
	 * Returns the amount of seconds since the given timestamp.
	 * @param {Number} timestamp The timestamp.
	 * @return {Number} Seconds since.
	 */
	getSecondsSince: function(timestamp) {
		var now = Math.round(new Date().getTime() / 1000);
		return now - timestamp;
	},

	/**
	 * Formats seconds as hours, minutes and seconds.
	 * @param {Number} seconds The seconds.
	 * @return {String} The formatted time.
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