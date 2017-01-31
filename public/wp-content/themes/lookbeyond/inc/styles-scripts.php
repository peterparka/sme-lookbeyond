<?php

/**
 * Enqueue scripts and styles
 */
function arc_scripts() {
	global $post;

	wp_enqueue_style( 'scripts', get_stylesheet_uri(), false, '', 'screen' );

	/**
	 * Remove jQuery from being automatically output on front end
	 */
	if (!is_admin()) {
		wp_deregister_script('jquery');
	}

	// work out if there is a codekit concatenated/minified version. If so, include that, otherwise, include core.js. If no javascript, don't include anything!
	$javascript_file = (file_exists(get_stylesheet_directory() . '/_js/scripts.min.js')) ? 'scripts.min.js'
				: ((file_exists(get_stylesheet_directory() . '/_js/scripts.js')) ? 'scripts.js' : false);

	if ($javascript_file) {
		// get modified time for smart caching
		$modified_time = filemtime(get_stylesheet_directory()."/_js/$javascript_file");
		wp_enqueue_script( 'scripts', get_template_directory_uri() . "/_js/$javascript_file?" . $modified_time, 'jquery', '1', true );
	}


	// Can query for different types of pages/templates (using arc_is_template('TEMPLATE_NAME'); ) and include scripts when needed...
	// Especially handy for scrolling banners on the homepage etc
	/*
	if ( is_front_page() ) {
		// enqueue jCarousel or similar!
	}
	*/
}
add_action( 'wp_enqueue_scripts', 'arc_scripts' );
