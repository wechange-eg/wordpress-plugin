<?php

/**
 * Shortcode to echo statistics information
 * 
 * Usage: [statistics attribute="groups"]
 */

namespace WechangeCollection;

function create_statistics_shortcode($atts) {

	$atts = shortcode_atts(
		array(
			'attribute' => '',
		),
		$atts,
		'wechange-statistics'
	);

	$attribute = $atts['attribute'];

	if ( empty( $attribute ) ) {
		return '<span style="color: red;">' . __('Please define attribute to return statistic', 'wechange-collection') . '</span>';
	}

	if ( false === ( $statistics_output = get_transient( 'wechance-collection-statistic-' . $attribute ) ) ) {
		// It wasn't there, so regenerate the data and save the transient
		$scope = '';
		if ( defined( 'WECHANGE_SCOPE' ) && ! empty( trim( 'WECHANGE_SCOPE' ) ) ) {
			$scope = 'managed_tag/' . trim( WECHANGE_SCOPE ) . '/';
		}
		$api_url      = trailingslashit( WECHANGE_BASE_URL ). 'api/v1/statistics/general/' . $scope;
		$api_response = file_get_contents( $api_url );
		$statistic    = json_decode($api_response);
	
		$statistics_output = $statistic->{$atts["attribute"]};
		if ( ! isset( $statistics_output ) ) {
			$statistics_output = '<span style="color: red;">' . __('Please check attribute. Attribute doesn\'t seem to exist', 'wechange-collection') . '</span>';
		}
		set_transient( 
			'wechance-collection-statistic-' . $attribute, 
			$statistics_output, 
			apply_filters( 'wechange_collection_cache_time_statistics', wechange_collection_cache_time() )
		);
	}

	return $statistics_output;
}
add_shortcode( 'wechange-statistics', __NAMESPACE__ . '\create_statistics_shortcode' );

