<?php
/**
 * Right sidebar check.
 *
 * @package fundament_wp
 */
?>

<?php $sidebar_pos = fundament_wp_get_theme_mod( 'theme_layout_sidebar' ); ?>

<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

  <?php get_sidebar( 'right' ); ?>

<?php endif; ?>
