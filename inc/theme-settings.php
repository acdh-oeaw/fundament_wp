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
    // Latest blog posts style.
    $fundament_wp_posts_index_style = get_theme_mod( 'fundament_wp_posts_index_style' );
    if ( !$fundament_wp_posts_index_style ) {
      set_theme_mod( 'fundament_wp_posts_index_style', 'default' );
    }

    // Default Fonts
    $fundament_wp_font_body_family = "inherit";
    $fundament_wp_font_body_variant = "400";
    $fundament_wp_font_heading_family = "inherit";
    $fundament_wp_font_heading_variant = "500";
    $fundament_wp_font_article_family = "inherit";
    $fundament_wp_font_article_variant = "400";

    $fonts_body = get_theme_mod( 'typography_body', array() );
    if ( !$fonts_body ) {
      set_theme_mod( 'typography_body', array("font-family" => $fundament_wp_font_body_family, "variant" => $fundament_wp_font_body_variant) );
    }
    $fonts_heading = get_theme_mod( 'typography_heading', array() );
    if ( !$fonts_heading ) {
      set_theme_mod( 'typography_heading', array("font-family" => $fundament_wp_font_heading_family, "variant" => $fundament_wp_font_heading_variant) );
    }
    $fonts_article = get_theme_mod( 'typography_article', array() );
    if ( !$fonts_article ) {
      set_theme_mod( 'typography_article', array("font-family" => $fundament_wp_font_article_family, "variant" => $fundament_wp_font_article_variant) );
    }

	}
endif;

function fundament_wp_extra_customizer_options( $wp_customize ) {

  // Extend some default WordPress sections
  $wp_customize->add_setting(
      'site_title_with_logo',
      array(
          'default' => false,
      )
  );
  $wp_customize->add_control(
     new WP_Customize_Control(
         $wp_customize,
         'site_title_with_logo',
         array(
             'label'      => __( 'Display Logo and Site Title Together', 'fundament_wp' ),
             'section'    => 'title_tagline',
             'settings'   => 'site_title_with_logo',
             'type'       => 'checkbox',
             'priority'   => 9
         )
     )
  );


}
add_action('customize_register','fundament_wp_extra_customizer_options');