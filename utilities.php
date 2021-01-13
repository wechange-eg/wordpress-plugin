<?php

namespace WechangeCollection;

function admin_notice_missing_wechange_base_url() {
	$class = 'notice notice-error';
	$message = __( 'Information missing: For communication with the WECHANGE API we need to know you WECHANGE base URL. 
Please define it in you wp-config.php file like define( "WECHANGE_BASE_URL", "https://wechange");', 'wechange-collection' );
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
if ( ! defined( 'WECHANGE_BASE_URL' ) ) {
	add_action( 'admin_notices', __NAMESPACE__ . '\admin_notice_missing_wechange_base_url' );
}



function load_textdomain() {
	load_plugin_textdomain( 'wechange-collection', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

function wechange_collection_cache_time() {
	return apply_filters( 'wechange_collection_cache_time', 2 * HOUR_IN_SECONDS );
}