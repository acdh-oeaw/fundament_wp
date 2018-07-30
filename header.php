<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package fundament_wp
 */

$container = get_theme_mod( 'theme_layout_container', 'container' );
$navbar_color_scheme = get_theme_mod( 'navbar_color_scheme', 'navbar-light' );
$navbar_placement = get_theme_mod( 'navbar_placement' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="hfeed site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
<div class="wrapper-fluid wrapper-navbar <?php echo $navbar_placement; ?>" id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

		<a class="skip-link screen-reader-text sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'fundament_wp' ); ?></a>

		<nav class="navbar navbar-expand-lg <?php echo $navbar_color_scheme; ?>">

		<?php if ( 'container' == $container ) : ?>
			<div class="container" >
		<?php endif; ?>

					<!-- Your site title as branding in the menu -->
					<?php $site_title_with_logo = get_theme_mod( 'site_title_with_logo', false ); ?>
					<?php if ( has_custom_logo() ) {
						the_custom_logo();
					} ?><!-- end custom logo -->
					<?php if ( ! has_custom_logo() || $site_title_with_logo ) { ?>
						<a class="navbar-brand<?php if ( has_custom_logo() ) { ?> site-title-with-logo<?php } ?>" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a><?php } ?>


				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
  				<!-- The WordPress Menu goes here -->
  				<?php wp_nav_menu(
  					array(
  						'theme_location'  => 'primary',
  						'container'       => false,
  						'menu_class'      => 'navbar-nav',
  						'fallback_cb'     => '',
  						'menu_id'         => 'main-menu',
  						'walker'          => new fundament_wp_WP_Bootstrap_Navwalker(),
  					)
  				); ?>

          <?php $navbar_search_toggle = fundament_wp_get_theme_mod( 'navbar_search_toggle', false );
            if ($navbar_search_toggle) { ?>
            <form class="form-inline my-2 my-lg-0 navbar-search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
              <input class="form-control navbar-search" id="s" name="s" type="text" placeholder="<?php esc_attr_e( 'Search', 'fundament_wp' ); ?>" value="<?php the_search_query(); ?>" autocomplete="off">
              <button type="submit" class="navbar-search-icon">
                <i data-feather="search"></i>
              </button>
            </form>
          <?php } ?>

          <?php $navbar_social_twitter = get_theme_mod( 'navbar_social_twitter', '' );
            if ($navbar_social_twitter) { ?>
              <a href="<?php echo $navbar_social_twitter; ?>" class="navbar-social-icon" target="_blank" rel="noopener">
                <i data-feather="twitter"></i>
              </a>
          <?php } ?>

          <?php $navbar_social_facebook = get_theme_mod( 'navbar_social_facebook', '' );
            if ($navbar_social_facebook) { ?>
              <a href="<?php echo $navbar_social_facebook; ?>" class="navbar-social-icon" target="_blank" rel="noopener">
                <i data-feather="facebook"></i>
              </a>
          <?php } ?>

        </div><!-- .collapse navbar-collapse -->

			<?php if ( 'container' == $container ) : ?>
			</div><!-- .container -->
			<?php endif; ?>

		</nav><!-- .site-navigation -->

	</div><!-- .wrapper-navbar end -->
