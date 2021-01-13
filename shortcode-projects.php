<?php

namespace WechangeCollection;
/**
 * List WECHANGE projects
 */

// Projects shortcode
function output_wechange_projects( $atts ) {

	$atts = shortcode_atts(
		array(
			'url'        => trailingslashit( WECHANGE_BASE_URL ),
			'parameters' => '',
		),
		$atts,
		'wechange_projects'
	);

	$url        = $atts['url'];
	$parameters = $atts['parameters'];
	
	$api_url  = $url . '/api/v2/projects/?' . $parameters;

	$url_hash = wp_hash( $api_url, 'nonce' );

	if ( false === ( $projects_html = get_transient( 'wechance-collection-projects-' . $url_hash ) ) ) {
		// It wasn't there, so regenerate the data and save the transient

		$projects_html = get_projects_from_api( $api_url );

		set_transient( 
			'wechance-collection-projects-' . $url_hash , 
			$projects_html, 
			apply_filters( 'wechange_collection_cache_time_projects', wechange_collection_cache_time() )
		);
	}

	return $projects_html;
	
}
add_shortcode( 'wechange_projects', __NAMESPACE__ . '\output_wechange_projects' );


function get_projects_from_api( $url ) {
			// Get projects
			$projects = array();

			$handle = curl_init();
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_URL, $url );
			$result = curl_exec($handle);
			$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
			curl_close($handle);
			if ($httpCode == 200) {
				$result = json_decode($result);
				// Add domain to each project
				$domain = parse_url( $url )['host'];
				foreach ($result->results as $result) {
					$result->domain = $domain;
					$projects[] = $result;
				}
			}
			
			if ( empty( $projects ) ) {
				return 'No projects found';
			}
	
			$projects_html_main = [];
			foreach ( $projects as $project ) {
				$projects_html_main[] = get_project_html( $project );
			}
			
			$projects_html_main = implode( $projects_html_main );
	
			$projects_html_before = apply_filters( 'wechange_collection_projects_html_before', '<section class="wechange-projects">');
			$projects_html_after  = apply_filters( 'wechange_collection_projects_html_after', '</section>');
	
			$projects_html = $projects_html_before . $projects_html_main . $projects_html_after;

			return $projects_html;
}

function get_project_html( $project ) {
	ob_start(); 

	$template_loader = new WechangeCollection_Template_Loader;
	$template_loader->set_template_data( [ 'project' => $project ] )
	->get_template_part( 'project' );

	// Store output buffer
	$project_html = ob_get_clean();
	
	return $project_html;
}