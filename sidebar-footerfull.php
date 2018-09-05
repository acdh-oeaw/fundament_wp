<?php
/**
 * Sidebar setup for footer full.
 *
 * @package fundament_wp
 */

$container = get_theme_mod( 'theme_layout_container', 'container' );

?>

<?php if ( is_active_sidebar( 'footerfull' ) ) : ?>

	<!-- ******************* The Footer Full-width Widget Area ******************* -->

	<div class="wrapper" id="wrapper-footer-full">

		<div class="<?php echo esc_attr( $container ); ?>" id="footer-full-content" tabindex="-1">

			<div class="row">

				<?php dynamic_sidebar( 'footerfull' ); ?>

<div class="row">

				<div id="text-3" class="footer-widget widget_text widget-count-1 col-md-12 mt-4">			<div class="textwidget"><div class="page" title="Page 3">
<div class="section">
<div class="layoutArea">
<div class="column">
<p>© 2018 Clovis Enterprise Limited registered in England and Wales. Company Number: 11087425. Registered Office: 10 Weyacres, Borrowash, Derbyshire, England, DE72 3QT</p>
</div>
</div>
</div>
</div>
</div>
		</div><!-- .footer-widget -->
			</div>

			</div>

		</div>

	</div><!-- #wrapper-footer-full -->

<?php endif; ?>
