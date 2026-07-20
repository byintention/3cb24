(function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var elements = document.querySelectorAll( '.event-local-time[data-event-start]' );

		elements.forEach( function ( el ) {
			var iso = el.getAttribute( 'data-event-start' );
			if ( ! iso ) {
				return;
			}

			var date = new Date( iso );
			if ( isNaN( date.getTime() ) ) {
				return;
			}

			var browserTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

			// Don't show a redundant "local time" for UK visitors - it's the same time already shown.
			if ( browserTimeZone === 'Europe/London' ) {
				return;
			}

			var formatted = date.toLocaleTimeString( undefined, {
				hour: 'numeric',
				minute: '2-digit',
				timeZoneName: 'short'
			} );

			el.textContent = ' (' + formatted + ' your local time)';
		} );
	} );
})();
