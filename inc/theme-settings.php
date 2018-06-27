<?php
/**
 * Check and setup theme's default settings
 *
 * @package fundament_wp
 *
 */

if ( ! function_exists( 'fundament_wp_get_theme_mod' ) ) {
  function fundament_wp_get_theme_mod( $field_id, $default_value = '' ) {
    if ( $field_id ) {
      if ( !$default_value ) {
        if ( class_exists( 'Kirki' ) && isset( Kirki::$fields[ $field_id ] ) && isset( Kirki::$fields[ $field_id ]['default'] ) ) {
          $default_value = Kirki::$fields[ $field_id ]['default'];
        }
      }
      $value = get_theme_mod( $field_id, $default_value );
      return $value;
    }
    return false;
  }
}

if ( ! function_exists( 'fundament_wp_add_fundament_default_footer' ) ) {
  function fundament_wp_add_fundament_default_footer() {
    $footer_default_fundament = fundament_wp_get_theme_mod( 'footer_default_fundament' );
    if ($footer_default_fundament) {
      $container = fundament_wp_get_theme_mod( 'theme_layout_container', 'container' );
      $content = '
      <div class="wrapper" id="wrapper-footer-fundament">
        <div class="'. esc_attr( $container ) .'" id="footer-fundament-content" tabindex="-1">
          <div class="row">
            <div id="custom_html-4" class="widget_text footer-widget widget_custom_html widget-count-3 col-md-2">
              <div class="textwidget custom-html-widget">
                <a href="/"><img src="http://localhost/dev/acdh/fundament_wp/wp-content/uploads/2018/06/acdh_logo.svg" class="image" alt="ACDH Logo" style="max-width: 100%; min-width: 8rem; height: auto;" title="ACDH Logo"></a>
              </div>
            </div><!-- .footer-widget -->
            <div id="custom_html-3" class="widget_text footer-widget widget_custom_html widget-count-3 col-md-4">
              <div class="textwidget custom-html-widget">
                <p>
                  ACDH-ÖAW
                  <br>
                  Austrian Centre for Digital Humanities
                  <br>
                  Austrian Academy of Sciences
                </p>
                <p>
                  Sonnenfelsgasse 19,
                  <br>
                  1010 Vienna
                </p>
                <p>
                  T: +43 1 51581-2200
                  <br>
                  E: <a href="javascript:linkTo_UnCryptMailto("nbjmup;bdeiApfbx/bd/bu");">acdh(at)oeaw.ac.at</a>
                </p>
              </div>
            </div><!-- .footer-widget -->
            <div id="custom_html-5" class="widget_text footer-widget widget_custom_html widget-count-3 col-md-4 ml-auto">
              <div class="textwidget custom-html-widget">
                <h3>HELPDESK</h3>
                <p>ACDH runs a helpdesk offering advice for questions related to various digital humanities topics.</p>
                <p>
                  <a class="helpdesk-button" href="javascript:linkTo_UnCryptMailto("nbjmup;bdeiApfbx/bd/bu");">ASK US!</a>
                </p>
              </div>
            </div><!-- .footer-widget -->
          </div>
        </div>
      </div><!-- #wrapper-footer-fundament -->
      <div class="footer-imprint-bar">
        © Copyright OEAW | <a href="https://arche.acdh.oeaw.ac.at/browser/imprint">Impressum/Imprint</a>
      </div>
      ';
      echo $content;
    } else {
      return false;
    }
  }
  add_action('get_footer', 'fundament_wp_add_fundament_default_footer');
}

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