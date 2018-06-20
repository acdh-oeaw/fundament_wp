<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package fundament_wp
 */

if ( ! function_exists( 'fundament_wp_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function fundament_wp_entry_meta($avatar = true, $author = true, $postdate = true, $readingtime = false, $icons = true, $tags = false, $authorbio = false, $avatarsize = 40) {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	if ($avatar) {
  	$gravatar = sprintf(
  		'<a class="author-avatar" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_avatar( get_the_author_meta( 'ID' ), $avatarsize ) . '</a>'
  	);
	} else { $gravatar = ''; }
	if ($author) {
  	$authorname = sprintf(
  		'<a class="author-name" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
  	);
  } else { $authorname = ''; }
  if ($postdate) {
  	$posted_on = sprintf(
  		'<a class="post-date" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
  	);
  } else { $posted_on = ''; }
  if ($readingtime) {
    // Estimate reading time
    $postcontent = get_the_content();
    $words = str_word_count(strip_tags($postcontent));
    $mins = floor($words / 200);
    if ($mins < 1) { $mins = '1'; }
    $estimated = $mins . __( ' min', 'fundament_wp' ) . __( ' read', 'fundament_wp' );
    if (!empty($postdate)) { $readingtime = sprintf('<span class="reading-time"><span class="dot"></span>'); } else { $readingtime = '<span class="reading-time">'; }
  	$readingtime .= sprintf(
  		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $estimated . '</a></span>'
  	);
  } else { $readingtime = ''; }
  if ($authorbio) {
  	$authorbio = sprintf(
  		'<span class="author-bio">' . esc_attr( get_the_author_meta('description') ) . '</span>'
  	);
  } else { $authorbio = ''; }
	echo $gravatar . '<span class="author-meta">' . $authorname . $authorbio . $posted_on . $readingtime .'</span>'; // WPCS: XSS OK.
	// Entry meta icons
	if ($icons OR $tags) {
    echo '<div class="entry-meta-icons">';
    if ($icons) {
    	$readicon = sprintf(
    		'<a class="read-post-icon" href="' . esc_url( get_permalink() ) . '" rel="bookmark" title="' . __( 'Read More', 'fundament_wp' ) . '"><i data-feather="bookmark"></i></a>'
    	);
    	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    		comments_popup_link( '', esc_html__( '1', 'fundament_wp' ) . '<i data-feather="message-circle"></i>', esc_html__( '%', 'fundament_wp' ) . '<i data-feather="message-circle"></i>', 'comments-link' );
    	}
      edit_post_link( '<i data-feather="edit-3"></i>' );
    	echo $readicon;
    }
    if ($tags) {
    	// Hide category and tag text for pages.
    	if ( 'post' === get_post_type() ) {
    		/* translators: used between list items, there is a space after the comma */
    		$tags_list = get_the_tag_list( '<span><i data-feather="hash"></i>', '</span><span><i data-feather="hash"></i>', '</span>' );
    		if ( $tags_list ) {
    			printf( '<span class="tags-links">' . $tags_list . '</span>' ); // WPCS: XSS OK.
    		}
    	}
    }
  	echo '</div>';
	}
}
endif;

if ( ! function_exists( 'fundament_wp_entry_list_categories' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function fundament_wp_entry_list_categories() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'fundament_wp' ) );
		if ( $categories_list && fundament_wp_categorized_blog() ) {
			printf( '<span class="entry-cat-links"><i data-feather="archive"></i>' . $categories_list . '</span>' ); // WPCS: XSS OK.
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function fundament_wp_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'fundament_wp_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );
		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'fundament_wp_categories', $all_the_cool_cats );
	}
	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so components_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so components_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in fundament_wp_categorized_blog.
 */
function fundament_wp_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'fundament_wp_categories' );
}
add_action( 'edit_category', 'fundament_wp_category_transient_flusher' );
add_action( 'save_post',     'fundament_wp_category_transient_flusher' );

