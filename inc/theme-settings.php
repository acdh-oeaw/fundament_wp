<?php
/**
 * Check and setup theme's default settings
 *
 * @package fundament_wp
 *
 */

if ( ! function_exists( 'fundament_wp_setup_theme_default_settings' ) ) :
	function fundament_wp_setup_theme_default_settings() {

		// check if settings are set, if not set defaults.
		// Caution: DO NOT check existence using === always check with == .
		// Latest blog posts style.
		$fundament_wp_posts_index_style = get_theme_mod( 'fundament_wp_posts_index_style' );
		if ( '' == $fundament_wp_posts_index_style ) {
			set_theme_mod( 'fundament_wp_posts_index_style', 'default' );
		}



	}
endif;
