<?php
/**
 * Single post partial template.
 *
 * @package fundament_wp
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

  <?php 
    $single_posts_layout_order = fundament_wp_get_theme_mod( 'single_posts_layout_order' );

    foreach ($single_posts_layout_order as $layout_area) {
      if ($layout_area == 'entry_meta') {
        $avatar = fundament_wp_get_theme_mod( 'post_avatar_toggle', true );
  			$author = fundament_wp_get_theme_mod( 'post_author_toggle', true );
  			$postdate = fundament_wp_get_theme_mod( 'post_postdate_toggle', true );
  			$readingtime = fundament_wp_get_theme_mod( 'post_readingtime_toggle', false );
  			$icons = fundament_wp_get_theme_mod( 'post_icons_toggle', false );
  			$tags = fundament_wp_get_theme_mod( 'post_tags_toggle', true );
  			$authorbio = fundament_wp_get_theme_mod( 'post_authorbio_toggle', true );

        if ($avatar OR $author OR $postdate OR $readingtime OR $icons OR $tags OR $authorbio) {
          echo '<div class="entry-meta">';
          fundament_wp_entry_meta($avatar, $author, $postdate, $readingtime, $icons, $tags, $authorbio, 60);
          echo '</div><!-- .entry-meta -->';
        }
      } else if ($layout_area == 'featured_image') {
        $postThumbnail = get_the_post_thumbnail( $post->ID, 'large' ); 
        if ($postThumbnail) { 
          $postThumbnailCaption = get_post(get_post_thumbnail_id())->post_excerpt;
          echo '<div class="entry-top-thumbnail">'.$postThumbnail.'</div>'; 
          if(!empty($postThumbnailCaption)){ 
            echo '<div class="entry-top-thumbnail-caption">' . $postThumbnailCaption . '</div>';
          }
        }
      } else if ($layout_area == 'post_title') {
        $post_category_toggle = get_theme_mod( 'post_category_toggle', true ); 
        if ($post_category_toggle) { 
          fundament_wp_entry_list_categories(); 
        }
        the_title( '<h1 class="entry-title">', '</h1>' );
      } else if ($layout_area == 'post_teaser') {
  			if ( has_excerpt() ) {
    			$excerpt = get_the_excerpt();
  				echo '<p class="post-teaser">'.esc_attr($excerpt).'</p>';
  			}
      }
    }
  ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'fundament_wp' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
