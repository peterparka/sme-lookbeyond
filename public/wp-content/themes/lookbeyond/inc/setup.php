<?php

/**
 * Filter Yoast WordPress SEO plugin Open Graph image size
 *
 * Default: medium
 *
 */
add_filter( 'wpseo_opengraph_image_size', 'ac_wpseo_image_size', 10, 1 );

function ac_wpseo_image_size( $string ) {

	return 'large';
}
