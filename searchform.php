<?php
/**
 * The template for displaying search forms in Underscores.me
 *
 * @package fundament_wp
 */

?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<h5 class="widget-title"><span class="separator-title"><?php esc_html_e( 'Search', 'fundamentwp' ); ?></span></h5>
	<div class="input-group">
		<input class="field form-control" id="s" name="s" type="text"
			placeholder="<?php esc_attr_e( 'Search &hellip;', 'fundamentwp' ); ?>" value="<?php the_search_query(); ?>">
		<span class="input-group-btn">
			<input class="submit btn btn-primary" id="searchsubmit" name="submit" type="submit"
			value="<?php esc_attr_e( 'Search', 'fundamentwp' ); ?>">
	</span>
	</div>
</form>
