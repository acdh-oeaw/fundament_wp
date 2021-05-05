<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package fundament_wp
 */

//Extract variables from the query
extract( $wp_query->query_vars );
if (!$blocks_per_row) { 
  $blocks_per_row = fundament_wp_get_theme_mod( 'archive_columns_per_row', 'col-md-12' );
}
if (!$blocks_layout_type) {
  $blocks_layout_type = fundament_wp_get_theme_mod( 'archive_blocks_layout_type', 'card-vertical' );
}
// Get the card style selection
$card_predefined_style = fundament_wp_get_theme_mod( 'card_predefined_style', 'flat-style' );

$articleClasses = array(
  'card',
  $blocks_per_row,
  $card_predefined_style
);
?>
<article <?php post_class($articleClasses); ?> id="post-<?php the_ID(); ?>">

  <div class="card-inner <?php echo esc_attr( $blocks_layout_type ); ?>" style="min-height:<?php echo $blocks_min_height; ?>;">

  <?php 
    $postThumbnail = get_the_post_thumbnail( $post->ID, 'large' ); 
    if ( $postThumbnail && $blocks_layout_type != 'card-no-image' ) { echo '<a class="entry-top-thumbnail" style="height:'.$blocks_image_height.';" href="'.esc_url( get_permalink() ).'" rel="bookmark">'.$postThumbnail; }
    if ( $blocks_layout_type == 'card-image-overlay') { echo '<div class="card-overlay-background" style="background-color:'.$blocks_overlay_color.'"></div>'; }
    if ( $postThumbnail && $blocks_layout_type != 'card-no-image' ) { echo '</a>'; }
  ?>

    <div class="entry-text-content">

    	<header class="entry-header">
      	
      	<?php $card_category_toggle = fundament_wp_get_theme_mod( 'card_category_toggle', true ); if ($card_category_toggle) { fundament_wp_entry_list_categories(); } ?>

    		<?php 
      		if ( is_sticky() ) { $sticky = '<i data-feather="star" class="sticky-icon"></i>'; } else { $sticky = ''; }
      		the_title( sprintf( '<h4 class="entry-title">'.$sticky.'<a href="%s" rel="bookmark" class="'.$blocks_overlay_text_color.'">', esc_url( get_permalink() ) ),'</a></h4>' );
        ?>
    
    	</header><!-- .entry-header -->
    
    	<div class="entry-content">
    
    		<?php
    		the_excerpt();
    		?>

        <?php if (fundament_wp_get_theme_mod( 'card_readmore_toggle' )) { ?>
          <a class="btn btn-round mb-1" href="<?php echo esc_url( get_permalink( get_the_ID() )); ?>"><?php echo __( 'Read More','fundamentwp' ); ?></a>
        <?php } ?>

    		<?php
    		wp_link_pages( array(
    			'before' => '<div class="page-links">' . __( 'Pages:', 'fundament_wp' ),
    			'after'  => '</div>',
    		) );
    		?>
    
    	</div><!-- .entry-content -->
    
    	<?php if ( 'post' == get_post_type() ) {
  			$avatar = fundament_wp_get_theme_mod( 'card_avatar_toggle' );
  			$author = fundament_wp_get_theme_mod( 'card_author_toggle' );
  			$postdate = fundament_wp_get_theme_mod( 'card_postdate_toggle' );
  			$readingtime = fundament_wp_get_theme_mod( 'card_readingtime_toggle' );
  			$icons =  fundament_wp_get_theme_mod( 'card_icons_toggle' );
  			$tags =  fundament_wp_get_theme_mod( 'card_tags_toggle' );
        if ($avatar OR $author OR $postdate OR $readingtime OR $icons OR $tags) {
      ?>
          <div class="entry-meta <?php if (fundament_wp_get_theme_mod( 'card_readmore_toggle' )) { echo 'mt-3'; } ?>">
          <?php fundament_wp_entry_meta($avatar, $author, $postdate, $readingtime, $icons, $tags); ?>
    		  </div><!-- .entry-meta -->
    	<?php } } ?>
  
    </div><!-- .entry-text-content -->

	</div><!-- .card-inner -->

</article><!-- #post-## -->
