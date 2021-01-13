<?php

namespace WechangeCollection;

/**
 * Proper way to enqueue scripts and styles.
 */
function login_status_script() {

    if ( ! current_theme_supports( 'wechange-collection-login-status' ) ) {
        return;
    }

    if ( is_user_logged_in() ) {
        return;
    }

    wp_enqueue_script( 'wechange-collection-login-status', plugin_dir_url( __FILE__ ) . '/login-status.js', array( 'jquery' ), '0.1.0', true );

    // Localize the script with new data
    $localization = array(
        'baseUrl' => trailingslashit( WECHANGE_BASE_URL ),
    );
    wp_localize_script( 'wechange-collection-login-status', 'wechangeCollection', $localization );
    
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ .'\login_status_script' );