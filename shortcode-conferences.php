<?php

namespace WechangeCollection;
/**
 * List WECHANGE conferences
 */

// Events shortcode
function output_wechange_conferences( $atts ) {

	$atts = shortcode_atts(
		array(
			'url'        => trailingslashit( WECHANGE_BASE_URL ),
			'parameters' => '',
			'upcoming'   => true
		),
		$atts,
		'wechange_conferences'
	);

	$url        = $atts['url'];
	$parameters = $atts['parameters'];

	//$scope = '';
	//if ( defined( 'WECHANGE_SCOPE' ) && ! empty( trim( 'WECHANGE_SCOPE' ) ) ) {
	//	$scope = '&managed_tag=' . trim( WECHANGE_SCOPE );
	//}

	//$parameters = $parameters . $scope;
	
	$api_url  = $url . '/api/v2/public_conferences/?' . $parameters;

	$url_hash = wp_hash( $api_url, 'nonce' );

	if ( false === ( $conferences_html = get_transient( 'wechance-collection-conferences-' . $url_hash ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		$conferences_html = get_conferences_from_api( $api_url );

		set_transient(
			'wechance-collection-conferences-' . $url_hash ,
			$conferences_html,
			apply_filters( 'wechange_collection_cache_time_conferences', wechange_collection_cache_time() )
		);
	}

	return $conferences_html;
	
}
add_shortcode( 'wechange_conferences', __NAMESPACE__ . '\output_wechange_conferences' );


function get_conferences_from_api( $url ) {
	
	$conferences = array();

	$handle = curl_init();
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_URL, $url);
	$result = curl_exec($handle);
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	curl_close($handle);
	if ($httpCode == 200) {
		$result = json_decode($result);
		// Add domain to each conference
		$domain = parse_url($url)['host'];
		foreach ($result->results as $result) {
			$result->domain = $domain;
			$conferences[] = $result;
		}
	}
	
	if ( empty( $conferences ) ) {
		return 'No conferences found';
	}

	$conferences_html_main = [];
	foreach ( $conferences as $conference ) {
		$conferences_html_main[] = get_conference_html( $conference );
	}
	
	$conferences_html_main = implode( $conferences_html_main );

	$conferences_html_before = apply_filters( 'wechange_collection_conferences_html_before', '<section class="wechange-conferences">');
	$conferences_html_after  = apply_filters( 'wechange_collection_conferences_html_after', '</section>');

	$conferences_html = $conferences_html_before . $conferences_html_main . $conferences_html_after;

	return $conferences_html;
}

function get_conference_html( $conference ) {
	ob_start(); 

	$Parsedown  = new \Parsedown();
	$conference->description = $Parsedown->setSafeMode(true)->text( $conference->description );

	$template_loader = new WechangeCollection_Template_Loader;
	$template_loader->set_template_data( [ 'conference' => $conference ] )
	->get_template_part( 'conference' );

	// Store output buffer
	$conference_html = ob_get_clean();
	
	return $conference_html;
}
