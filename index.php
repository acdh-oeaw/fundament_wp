<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package fundament_wp
 */

get_header();

$container = get_theme_mod( 'theme_layout_container', 'container' );
$home_content_blocks = get_theme_mod( 'home_content_blocks' );
if (!$home_content_blocks) { 
  //$home_content_blocks[0]["blocks_per_row"] = 'col-md-12'; 
}
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

      <!-- Use custom content block templates if they are defined -->
      <?php 
      if ($home_content_blocks) {
        foreach ($home_content_blocks as $home_content_block) {
          // Get the relevant home content block template for this type of content
          if (isset($home_content_block["blocks_type"])) { 
            set_query_var( 'home_content_block', $home_content_block );
            $blocks_type = $home_content_block["blocks_type"];
            get_template_part( 'loop-templates/home-content-block' );
          }
        }
      } else {
        // NORMAL INDEX QUERY
      }
      ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php fundament_wp_pagination(); ?>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>