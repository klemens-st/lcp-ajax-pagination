import '../sass/main.scss';

const $ = jQuery;

$( document ).ready( function() {
	$( '.lcpax-pagination' ).on( 'click', 'a', function( e ) {
		e.preventDefault();

		const $this = $( this );
		const url = $this.attr( 'href' );
		const params = new URL( url ).searchParams;

		let instance, instanceSelector;

		// Get LCP instance selector.
		params.forEach( ( value, key ) => {
			if ( 'lcp_page' === key.substring( 0, 8 ) ) {
				instance = key[ 8 ];
				instanceSelector = `#lcp_instance_${ instance }`;
			}
		} );

		$.get( url, ( data ) => {
			const $data = $( data );

			// Extract new entries and pagination links from fetched HTML.
			const newEntries = $data.find( instanceSelector ).children();
			const newPagination = $data.find( `.lcpax-instance-${ instance }` ).children();

			// Replace old entries with fetched ones.
			$( instanceSelector ).empty().append( newEntries );

			// Replace pagination.
			$( e.delegateTarget ).empty().append( newPagination );
		} );
	} );

	const loadmorePaginators = $( '.lcpax-loadmore' );
	loadmorePaginators.each( function() {
		const $paginator = $( this );
		const $nextlink = $paginator.find( '.lcp_nextlink' );
		const $wrapper = $( '<div class="lcpax-nextlink-wrapper"></div>' );
		const $spinner = $paginator.find( '.lcpax-spinner' );

		// Remove the title attr, should be removed from LCP anyway.
		$nextlink.removeAttr( 'title' );

		$wrapper.append( $nextlink );
		$wrapper.append( $spinner );

		$paginator.replaceWith( $wrapper );
	} );

	$( '.lcpax-nextlink-wrapper' ).on( 'click', '.lcp_nextlink', function( e ) {
		e.preventDefault();

		const $this = $( this );
		const url = $this.attr( 'href' );
		const params = new URL( url ).searchParams;
		const $spinner = $( e.delegateTarget ).find( '.lcpax-spinner' );

		let instance, instanceSelector;

		// Show the spinner.
		$spinner.css( 'display', 'inline' );

		// Get LCP instance selector.
		params.forEach( ( value, key ) => {
			if ( 'lcp_page' === key.substring( 0, 8 ) ) {
				instance = key[ 8 ];
				instanceSelector = `#lcp_instance_${ instance }`;
			}
		} );

		$.get( url, ( data ) => {
			const $data = $( data );

			// Extract new entries from fetched HTML.
			const newEntries = $data.find( instanceSelector ).children();

			// Append new entries.
			$( instanceSelector ).append( newEntries );

			// Update the link.
			const nextlinkUrl = $data.find( `.lcpax-instance-${ instance } .lcp_nextlink` ).attr( 'href' );
			if ( nextlinkUrl ) {
				$this.attr( 'href', nextlinkUrl );
			} else {
				// We have hit the last page and there is no next link.
				$this.remove();
			}

			// Hide the spinner.
			$spinner.css( 'display', '' );
		} );
	} );
} );
