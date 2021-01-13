<?php

namespace WechangeCollection;
/**
 * List WECHANGE notes
 */

// Notes shortcode
function output_wechange_notes( $atts ) {

	$atts = shortcode_atts(
		array(
			'url'        => trailingslashit( WECHANGE_BASE_URL ),
			'parameters' => '',
		),
		$atts,
		'wechange_notes'
	);

	$url        = $atts['url'];
	$parameters = $atts['parameters'];
	
	$api_url  = $url . '/api/v2/notes/?' . $parameters;

	$url_hash = wp_hash( $api_url, 'nonce' );

	if ( false === ( $notes_html = get_transient( 'wechance-collection-notes-' . $url_hash ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		$notes_html = get_notes_from_api( $api_url );

		set_transient(
			'wechance-collection-notes-' . $url_hash ,
			$notes_html,
			apply_filters( 'wechange_collection_cache_time_notes', wechange_collection_cache_time() )
		);
	}

	return $notes_html;
	
}
add_shortcode( 'wechange_notes', __NAMESPACE__ . '\output_wechange_notes' );


function get_notes_from_api( $url ) {
	
	$notes = array();

	$handle = curl_init();
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($handle, CURLOPT_URL, $url);
	$result = curl_exec($handle);
	$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
	curl_close($handle);
	if ($httpCode == 200) {
		$result = json_decode($result);
		// Add domain to each note
		$domain = parse_url($url)['host'];
		foreach ($result->results as $result) {
			$result->domain = $domain;
			$notes[] = $result;
		}
	}
	
	if ( empty($notes) ) {
		return 'No notes found';
	}

	$notes_html_main = [];
	foreach ( $notes as $note ) {
		$notes_html_main[] = get_note_html( $note );
	}
	
	$notes_html_main = implode( $notes_html_main );

	$notes_html_before = apply_filters( 'wechange_collection_notes_html_before', '<section class="wechange-notes">');
	$notes_html_after  = apply_filters( 'wechange_collection_notes_html_after', '</section>');

	$notes_html = $notes_html_before . $notes_html_main . $notes_html_after;

	return $notes_html;
}

function get_note_html( $note ) {
	ob_start(); 

	$Parsedown  = new \Parsedown();
	$note->text = $Parsedown->setSafeMode(true)->text( $note->text );

	$template_loader = new WechangeCollection_Template_Loader;
	$template_loader->set_template_data( [ 'note' => $note ] )
	->get_template_part( 'note' );

	// Store output buffer
	$note_html = ob_get_clean();
	
	return $note_html;
}