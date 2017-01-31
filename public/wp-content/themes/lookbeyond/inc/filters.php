<?php

define("THEME_DIR", get_template_directory_uri());

/**
 * Enqueue scripts and styles
 */
function arc_filters() {

	global $post;

	if( is_page('explore') ) {

		$categories = [];

		$post_types = [ 'post' ];

		// Types available = or, and, name_compare, count

		$filters = [
			[
				'name' => 'categories',
				'tax_name' => 'category', // only because the property names aren't matching up (!)
				'display_name' => 'Categories',
				'type' => 'or',
				'style' => 'dropdown',
				'has_all_button' => true
			],
			[
				'name' => 'tags',
				'tax_name' => 'post_tag',
				'display_name' => 'Tags',
				'type' => 'or',
				'style' => 'inline',
				'has_all_button' => true
			],
			[
				'name' => 'likes',
				'tax_name' => '',
				'display_name' => 'Most Loved',
				'type' => 'count',
				'style' => 'inline',
				'has_all_button' => false
			]
		];

		// $tag_filter_options

		foreach( $filters as &$filter )
		{
			$filter['options'] = [];

			if( $filter['type'] === 'count' )
			{
				array_push($filter['options'], [
					'id' => 0,
					'name' => 'likes',
					'display_name' => 'Most Loved'
				]);

			} else {

				// $terms = [];

				//foreach( $post_types as $post_type ) {

					//$taxonomy = get_object_taxonomies( $post_type )[0];

					$this_terms = get_terms([
						'taxonomy' => $filter['tax_name'],
						'hide_empty' => false
					]);

					// echo '<br>THESE TERMS:<br>';
					// var_dump($this_terms);

					foreach ($this_terms as $term) {

						array_push($filter['options'], [
							'id' => $term->term_id,
							'name' => $term->slug,
							'display_name' => $term->name
						]);
					}
				//}
			}
		}

		// echo '<pre>';
		// print_r($filters);
		// echo '</pre>';

		$args = array(
			'post_type' => $post_types,
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC'
		);

		// We then pass these to a wordpress query, and setup our loop
		$items_query = new WP_Query( $args );

		$sorted_items = [];

		if( $items_query->have_posts() ) : while( $items_query->have_posts() ): $items_query->the_post();

			$json  = json_encode(get_the_tags());
			$tags = json_decode($json, true);

			$post_id = get_the_ID();

			//$tags = (array) get_the_tags();

			$category = (array) get_the_terms( $post_id, 'category' )[0];

			$likes = get_post_meta( $post_id, 'vortex_system_likes', true );

			$this_item = [
				'id' => get_the_id(),
				'title' => get_the_title(),
				//'color' => strtolower(str_replace(' ', '-', get_field('color'))),
				'link_url' => get_the_permalink(),
				'date' => get_the_date('F j, Y'),
				'image_url' => wp_get_attachment_image_url( get_post_thumbnail_id(), 'medium' ),
				'tags_full' => $tags,
				'category' => $category,
				'favourites' => (int) $likes
			];

			foreach ($filters as &$filter) { // if don't pass reference here it's always the same category

				$terms = [];

				if( $filter['tax_name'] === 'categories' )
				{
					$terms = get_categories();

				} else { // it's a taxonomy

					$terms = wp_get_post_terms( get_the_id(), $filter['tax_name'] );
				}

				$cat_slugs = []; // SLUGS NOT ADDED YET
				$this_item[ $filter['name'] ] = []; // holds this category's ids

				if( count( $terms ) )
				{

					foreach( $terms as $term )
					{
						//print_r($term);
						array_push($this_item[ $filter['name'] ], $term->term_id );
						array_push($cat_slugs, $term->slug );
					}
				}
			}

			array_push( $sorted_items, $this_item );

		endwhile; endif;

		//
		// Removes the featured articles from all articles ( $sorted_items )
		//
		$page_post = get_page_by_path('explore');

		$featured_posts = get_field('featured_articles', $page_post->ID);

		foreach( $featured_posts as $featured_post )
		{
			foreach( $sorted_items as $index => $post )
			{
				if( $featured_post->ID === $post['id'] )
				{
					array_splice($sorted_items, $index, 1);
					break;
				}
			}
		}

		$filter_data = [
			'all_items' => $sorted_items,
			'filters' => $filters,
			'display_count' => 99
		];

		wp_enqueue_script('filter_object', get_template_directory_uri() . '/ajax.js');
		wp_localize_script( 'filter_object', 'filter_data', $filter_data );
	}


	$ajaxData = array(
		'ajaxurl' => admin_url('admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-users-nonce' ),
	);

	wp_enqueue_script('app', get_template_directory_uri() . '/ajax.js');
	wp_localize_script( 'app', 'WPaAjax', $ajaxData );
}

add_action( 'wp_enqueue_scripts', 'arc_filters' );

?>
