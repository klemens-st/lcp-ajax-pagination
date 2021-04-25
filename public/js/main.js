import '../sass/main.scss';

const $ = jQuery;

$( document ).ready( function() {
	$( '.lcpax-pagination' ).on( 'click', 'a', function( e ) {
		e.preventDefault();

		const $this = $( this );
		const url = $this.attr( 'href' );

		let instance, instanceSelector;

		// Get LCP instance info from the class that was added in PHP.
		e.delegateTarget.classList.forEach( ( cssClass ) => {
			if ( cssClass.startsWith( 'lcpax-instance-' ) ) {
				instance = cssClass.slice( 15 );
				instanceSelector = `#lcp_instance_${ instance }`;
			}
		} );

		// TODO: failure handler.
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

		// Add the instance class to the wrapper.
		this.classList.forEach( ( cssClass ) => {
			if ( cssClass.startsWith( 'lcpax-instance-' ) ) {
				$wrapper.addClass( cssClass );
			}
		} );

		// Remove the title attr, should be removed from LCP anyway.
		$nextlink.removeAttr( 'title' );

		$wrapper.append( $nextlink );
		$wrapper.append( $spinner );

		$paginator.replaceWith( $wrapper );
	} );

	$( '.lcpax-nextlink-wrapper' ).on( 'click', '.lcp_nextlink', function( e ) {
		e.preventDefault();
		const $this = $( this );

		// Check if nothing is already being loaded.
		if ( true === $this.data( 'lcpax-loading' ) ) {
			return;
		}

		// Flag the link so that it remains inactive until loading is finished.
		$this.data( 'lcpax-loading', true );

		const url = $this.attr( 'href' );
		const $spinner = $( e.delegateTarget ).find( '.lcpax-spinner' );

		let instance, instanceSelector;

		// Show the spinner.
		$spinner.css( 'display', 'inline' );

		// Get LCP instance info from the class that was added in PHP.
		e.delegateTarget.classList.forEach( ( cssClass ) => {
			if ( cssClass.startsWith( 'lcpax-instance-' ) ) {
				instance = cssClass.slice( 15 );
				instanceSelector = `#lcp_instance_${ instance }`;
			}
		} );

		// TODO: failure handler.
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
			// Unflag the link.
			$this.data( 'lcpax-loading', false );
		} );
	} );
} );
