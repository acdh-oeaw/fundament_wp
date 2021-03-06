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

$container = fundament_wp_get_theme_mod( 'theme_layout_container', 'container' );
$home_content_blocks = fundament_wp_get_theme_mod( 'home_content_blocks' );
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
      } else { ?>

      <div class="card-wrapper">
      <?php if ( have_posts() ) : ?>
      <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php
          /*
          * Include the Post-Format-specific template for the content.
          * If you want to override this in a child theme, then include a file
          * called content-___.php (where ___ is the Post Format name) and that will be used instead.
          */
          get_template_part( 'loop-templates/content', get_post_format() );
          ?>
        <?php endwhile; ?>
      <?php else : ?>
          <?php get_template_part( 'loop-templates/content', 'none' ); ?>
      <?php endif; ?>
      <div class="card-wrapper">

      <?php } ?>

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