<?php
/**
 * fundament_wp functions and definitions
 *
 * @package fundament_wp
 */

/**
 * Load Customizer controls.
 */
require get_template_directory() . '/inc/customizer-controls/customizer-controls.php';

/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/theme-settings.php';

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Comments file.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';


/**
 * Load the social media tags
 */

require get_template_directory() . '/inc/socialmedia.php';

//if we have the polylang plugin installed then we can add the theme related translations
if(is_plugin_active('polylang/polylang.php') && function_exists('pll_register_string')) {
    pll_register_string(get_theme_mod('hero_static_title'), 'fundament_wp_hero_dynamic_title', 'fundament_wp');
    pll_register_string(get_theme_mod('hero_static_text'), 'fundament_wp_hero_dynamic_text', 'fundament_wp');
    pll_register_string(get_theme_mod('hero_button'), 'fundament_wp_hero_dynamic_button', 'fundament_wp');
}