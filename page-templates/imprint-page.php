<?php
/**
 * Template Name: Imprint Page
 *
 * Template for displaying the ACDH-CH imprint page.
 *
 * @package fundament_wp
 */

get_header();

$container   = get_theme_mod( 'theme_layout_container', 'container' );

?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

					<div id="entry-content">
					<?php
					  $serviceID = get_theme_mod( 'imprint_redmine_ID', 9945 );
					  $outputLang = get_theme_mod( 'imprint_output_lang', '' );
					  $params = http_build_query(array(
					      'serviceID' => $serviceID,
					      'outputLang' => $outputLang
					  ));
					  $response = file_get_contents('https://shared.acdh.oeaw.ac.at/acdh-common-assets/api/imprint.php?'.$params);
					  echo $response;
					?>
					</div><!-- #entry-content -->

				</article><!-- #post-## -->

			</main><!-- #main -->

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
