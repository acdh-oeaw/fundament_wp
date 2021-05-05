<?php
/**
 * Carousel rendering content according to caller of get_template_part.
 *
 * @package fundament_wp
 */

extract( $wp_query->query_vars );

if ($home_content_block["carousel_layout_type"] == 'image-on-left') { $columnClass = 'col-md-6'; } else { $columnClass = ''; }
if ($home_content_block["carousel_stretch_layout"] == true) { $captionClass = 'container'; } else { $captionClass = ''; }

?>


<div class="carousel-item<?php if ($slide_number == 1) { ?> active<?php } ?>">
  <?php 
    $postThumbnail = get_the_post_thumbnail( $post->ID, 'large' ); 
    if ($postThumbnail) { echo '<a class="entry-top-thumbnail carousel-thumbnail '.$columnClass.'" href="'.esc_url( get_permalink() ).'" rel="bookmark">'.$postThumbnail.'</a>'; }
  ?>
  <div class="carousel-caption <?php echo $columnClass . ' ' . $captionClass; ?>">
    <?php
      $card_category_toggle = fundament_wp_get_theme_mod( 'card_category_toggle', true ); if ($card_category_toggle) { fundament_wp_entry_list_categories(); } 
      the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),'</a></h4>' );
      the_excerpt();
    ?>
    <a class="btn btn-round mb-1" href="<?php echo esc_url( get_permalink( get_the_ID() )); ?>"><?php echo __( 'Read More','fundamentwp' ); ?></a>

  </div>
</div>