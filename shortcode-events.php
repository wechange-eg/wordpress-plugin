<?php

namespace WechangeCollection;
/**
 * List WECHANGE events
 */

// Events shortcode
function output_wechange_events( $atts ) {

	$atts = shortcode_atts(
		array(
			'url'        => trailingslashit( WECHANGE_BASE_URL ),
			'parameters' => '',
			'upcoming'   => true
		),
		$atts,
		'wechange_events'
	);

	$url        = $atts['url'];
	$parameters = $atts['parameters'];

	$scope = '';
	if ( defined( 'WECHANGE_SCOPE' ) && ! empty( trim( 'WECHANGE_SCOPE' ) ) ) {
		$scope = '&managed_tag=' . trim( WECHANGE_SCOPE );
	}

	$parameters = $parameters . $scope;
	
	$api_url  = $url . '/api/v2/events/?' . $parameters;

	$url_hash = wp_hash( $api_url, 'nonce' );
	$lang     = apply_filters( 'wpml_current_language', NULL ); // WPML support

	if ( false === ( $events_html = get_transient( 'wechance-collection-events-' . $url_hash . $lang ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		$events_html = get_events_from_api( $api_url );

		set_transient(
			'wechance-collection-events-' . $url_hash . $lang ,
			$events_html,
			apply_filters( 'wechange_collection_cache_time_events', wechange_collection_cache_time() )
		);
	}

	return $events_html;
	
}
add_shortcode( 'wechange_events', __NAMESPACE__ . '\output_wechange_events' );


function get_events_from_api( $url ) {
	
	$events = array();

	$handle = curl_init();
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_URL, $url);
	$result = curl_exec($handle);
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	curl_close($handle);
	if ($httpCode == 200) {
		$result = json_decode($result);
		// Add domain to each event
		$domain = parse_url($url)['host'];
		foreach ($result->results as $result) {
			$result->domain = $domain;
			$events[] = $result;
		}
	}
	
	if ( empty( $events ) ) {
		return 'No events found';
	}

	$events_html_main = [];
	foreach ( $events as $event ) {
		$events_html_main[] = get_event_html( $event );
	}
	
	$events_html_main = implode( $events_html_main );

	$events_html_before = apply_filters( 'wechange_collection_events_html_before', '<section class="wechange-events">');
	$events_html_after  = apply_filters( 'wechange_collection_events_html_after', '</section>');

	$events_html = $events_html_before . $events_html_main . $events_html_after;

	return $events_html;
}

function get_event_html( $event ) {
	ob_start(); 

	$Parsedown  = new \Parsedown();
	$event->note = $Parsedown->setSafeMode(true)->text( $event->note );

	$template_loader = new WechangeCollection_Template_Loader;
	$template_loader->set_template_data( [ 'event' => $event ] )
	->get_template_part( 'event' );

	// Store output buffer
	$event_html = ob_get_clean();
	
	return $event_html;
}