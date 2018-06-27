<?php
/**
 * Template Name: Empty Wrapped Page Template
 *
 * Template for displaying a page just with the header and footer area and a "naked" content area in between.
 * Good for landingpages and other types of pages where you want to add a lot of custom markup.
 *
 * @package fundament_wp
 */

get_header();

$container   = get_theme_mod( 'theme_layout_container', 'container' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

    <?php
    while ( have_posts() ) : the_post();
    	get_template_part( 'loop-templates/content', 'empty' );
    endwhile;
    ?>

    </div><!-- .row -->

  </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>