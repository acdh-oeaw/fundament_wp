<?php
/**
 * Home block query processes the defined filters
 *
 * @package fundament_wp
 */

// Makes the $home_content_block object available
extract( $wp_query->query_vars );

if (isset($home_content_block["block_title"])) { $block_title = $home_content_block["block_title"]; }
if (isset($home_content_block["blocks_per_row"])) { $blocks_per_row = $home_content_block["blocks_per_row"]; }
if (isset($home_content_block["number_of_blocks"])) { $number_of_blocks = $home_content_block["number_of_blocks"]; }
if (isset($home_content_block["blocks_orderby"])) { $blocks_orderby = $home_content_block["blocks_orderby"]; }
if (isset($home_content_block["blocks_order"])) { $blocks_order = $home_content_block["blocks_order"]; }
if (isset($home_content_block["blocks_orderby_meta_key"])) { $blocks_orderby_meta_key = $home_content_block["blocks_orderby_meta_key"]; }
if (isset($home_content_block["blocks_image_height"])) { $blocks_image_height = $home_content_block["blocks_image_height"] . "px"; }
if (isset($home_content_block["blocks_min_height"])) { $blocks_min_height = $home_content_block["blocks_min_height"] . "px"; }
if (isset($home_content_block["blocks_overlay_color"])) { $blocks_overlay_color = $home_content_block["blocks_overlay_color"]; }
if (isset($home_content_block["blocks_overlay_text_color"])) { $blocks_overlay_text_color = $home_content_block["blocks_overlay_text_color"]; }

// Querying posts
if ($home_content_block["blocks_type"] == "cards-query-posts" || $home_content_block["blocks_type"] == "carousel-query-posts") {

  // Process the tag selection
  if (isset($home_content_block["blocks_post_tags_query"])) { 
    $blocks_post_tags_query = $home_content_block["blocks_post_tags_query"];
    if (strlen(implode($blocks_post_tags_query)) !== 0) {
      $blocks_post_tags_query = array(
    		'taxonomy' => 'post_tag',
    		'field'    => 'term_id',
    		'terms'    => $blocks_post_tags_query,
      );
    }
  } else { 
    $blocks_post_tags_query = ''; 
  }
  // Process the category selection
  if (isset($home_content_block["blocks_post_category_query"])) {
    $blocks_post_category_query = $home_content_block["blocks_post_category_query"];
    if (strlen(implode($blocks_post_category_query)) !== 0) {
      $blocks_post_category_query = array(
    		'taxonomy' => 'category',
    		'field'    => 'term_id',
    		'terms'    => $blocks_post_category_query,
      );
    }
  } else { 
    $blocks_post_category_query = ''; 
  }
  // Process the taxonomy relationship
  if ($blocks_post_tags_query && $blocks_post_category_query) {
    $blocks_tax_query = array(
  		'relation' => 'OR',
  		$blocks_post_tags_query,
  		$blocks_post_category_query
  	);
  } else if ($blocks_post_tags_query) { 
    $blocks_tax_query = array(
  		$blocks_post_tags_query
  	);
  } else if ($blocks_post_category_query) { 
    $blocks_tax_query = array(
  		$blocks_post_category_query
  	);
  } else {
    $blocks_tax_query = array();
  }
  //Query the defined content blocks
  $args = array(
  	'post_type' => 'post',
  	'posts_per_page' => $number_of_blocks,
  	'orderby' => $blocks_orderby,
  	'order' => $blocks_order,
  	'meta_key'  => $blocks_orderby_meta_key,
  	'tax_query' => $blocks_tax_query
  );

  // Process the layout type selection
  if (isset($home_content_block["blocks_layout_type"]) && $home_content_block["blocks_layout_type"]) { 
    $blocks_layout_type = $home_content_block["blocks_layout_type"]; 
  }

  $query = new WP_Query( $args );


// Querying pages
} else if ($home_content_block["blocks_type"] == "cards-query-pages"  || $home_content_block["blocks_type"] == "carousel-query-pages") {

  // Process the page selection
  if (isset($home_content_block["blocks_post_pages_query"])) { 
    $blocks_post_pages_query = $home_content_block["blocks_post_pages_query"];
    if (strlen(implode($blocks_post_pages_query)) !== 0) {
      $args = array(
        'post_type' => 'page',
        'post__in' => $blocks_post_pages_query,
        'orderby' => $blocks_orderby,
        'order' => $blocks_order,
        'meta_key'  => $blocks_orderby_meta_key,
      );
    }
  }

  // Process the layout type selection
  if (isset($home_content_block["blocks_layout_type"]) && $home_content_block["blocks_layout_type"]) { 
    $blocks_layout_type = $home_content_block["blocks_layout_type"]; 
  }

  if (isset($args)) {
    $query = new WP_Query( $args );
  }

// Output custom shortcode block
} else if ($home_content_block["blocks_type"] == "shortcode-block") {

  if (isset($home_content_block["blocks_shortcode"]) && $home_content_block["blocks_shortcode"]) {
    echo do_shortcode($home_content_block["blocks_shortcode"]);
  }

}


if ($home_content_block["blocks_type"] == "cards-query-posts" || $home_content_block["blocks_type"] == "cards-query-pages") {
  $blocks_type = 'cards';
} else if ($home_content_block["blocks_type"] == "carousel-query-posts" || $home_content_block["blocks_type"] == "carousel-query-pages") {
  $blocks_type = 'carousel';
}

if ( isset($query) ) {
  
  if ( $query->have_posts() ) {
    if (isset($block_title) && $block_title) { ?>
      <h5 class="content-block-title"><span class="separator-title"><?php echo esc_attr( $block_title ); ?></span></h5>
    <?php }
    if (isset($blocks_per_row) && $blocks_per_row) { set_query_var( 'blocks_per_row', $blocks_per_row ); } else { set_query_var( 'blocks_per_row', 'col-md-12' ); }
    if (isset($blocks_image_height) && $blocks_image_height) { set_query_var( 'blocks_image_height', $blocks_image_height ); } else { set_query_var( 'blocks_image_height', 'auto' ); }
    if (isset($blocks_min_height) && $blocks_min_height) { set_query_var( 'blocks_min_height', $blocks_min_height ); } else { set_query_var( 'blocks_min_height', 'auto' ); }
    if (isset($blocks_layout_type) && $blocks_layout_type) { set_query_var( 'blocks_layout_type', $blocks_layout_type ); } else { set_query_var( 'blocks_layout_type', 'card-vertical' ); }
    if (isset($blocks_overlay_color) && $blocks_overlay_color) { set_query_var( 'blocks_overlay_color', $blocks_overlay_color ); } else { set_query_var( 'blocks_overlay_color', '' ); }
    if (isset($blocks_overlay_text_color) && $blocks_overlay_text_color) { set_query_var( 'blocks_overlay_text_color', $blocks_overlay_text_color ); } else { set_query_var( 'blocks_overlay_text_color', 'light' ); }
    ?>
  
    <?php if ($blocks_type == 'cards') { ?>
      <div class="card-wrapper">
    <?php } else if ($blocks_type == 'carousel') { $slide_number = 0; $carousel_id = 'carousel-'.uniqid(); ?>
      <div id="<?php echo $carousel_id; ?>" class="carousel slide <?php echo $home_content_block["carousel_layout_type"]; if ($home_content_block["carousel_stretch_layout"] == true) { echo ' stretched'; } ?> " data-ride="carousel">
          <div class="carousel-inner">
    <?php } ?>
  
    <?php while ( $query->have_posts() ) : $query->the_post();
      /*
       * Include the Post-Format-specific template for the content.
       * If you want to override this in a child theme, then include a file
       * called content-___.php (where ___ is the Post Format name) and that will be used instead.
       */
      if ($blocks_type == 'carousel') { $slide_number++; set_query_var( 'slide_number', $slide_number ); set_query_var( 'home_content_block', $home_content_block ); }
      get_template_part( 'loop-templates/content-'.$blocks_type, get_post_format() );
    endwhile; ?>
  
  
    <?php if ($blocks_type == 'cards') { ?>
      </div><!-- .card-wrapper -->
    <?php } else if ($blocks_type == 'carousel') { ?>
      </div><!-- .carousel-inner -->
      <?php if ($slide_number > 1) { ?>
      <a class="carousel-control-prev" href="#<?php echo $carousel_id; ?>" role="button" data-slide="prev">
        <i data-feather="chevron-left"></i>
      </a>
      <a class="carousel-control-next" href="#<?php echo $carousel_id; ?>" role="button" data-slide="next">
        <i data-feather="chevron-right"></i>
      </a>
      <?php } ?>
    </div><!-- .carousel -->
    <?php } ?>
  
  <?php } else { //No results
    get_template_part( 'loop-templates/content', 'none' );
  }
  
  wp_reset_query();

}

?>
