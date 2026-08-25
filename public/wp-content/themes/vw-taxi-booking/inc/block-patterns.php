<?php
/**
 * VW Taxi Booking: Block Patterns
 *
 * @since VW Taxi Booking 1.0
 */

 /**
  * Get patterns content.
  *
  * @param string $file_name Filename.
  * @return string
  */
function vw_taxi_booking_get_pattern_content( $file_name ) {
	ob_start();
	include get_theme_file_path( '/patterns/' . $file_name . '.php' );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

/**
 * Registers block patterns and categories.
 *
 * @since VW Taxi Booking 1.0
 *
 * @return void
 */
function vw_taxi_booking_register_block_patterns() {

	$patterns = array(
		'header-default' => array(
			'title'      => __( 'Default header', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-headers' ),
			'blockTypes' => array( 'parts/header' ),
		),
		'footer-default' => array(
			'title'      => __( 'Default footer', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-footers' ),
			'blockTypes' => array( 'parts/footer' ),
		),
		'home-slider' => array(
			'title'      => __( 'Home Slider', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-home-slider' ),
		),
		'our-taxis-section' => array(
			'title'      => __( 'Our Taxis Section', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-our-taxis-section' ),
		),
		'experience-section' => array(
			'title'      => __( 'Experience Section', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-experience-section' ),
		),
		'testimonial-section' => array(
			'title'      => __( 'Testimonial Section', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-testimonial-section' ),
		),
		'news-section' => array(
			'title'      => __( 'News Section', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-news-section' ),
		),
		'faq-section' => array(
			'title'      => __( 'FAQ Section', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-faq-section' ),
		),
		'primary-sidebar' => array(
			'title'    => __( 'Primary Sidebar', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-sidebars' ),
		),
		'hidden-404' => array(
			'title'    => __( '404 content', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-pages' ),
		),
		'post-listing-single-column' => array(
			'title'    => __( 'Post Single Column', 'vw-taxi-booking' ),
			//'inserter' => false,
			'categories' => array( 'vw-taxi-booking-query' ),
		),
		'post-listing-two-column' => array(
			'title'    => __( 'Post Two Column', 'vw-taxi-booking' ),
			//'inserter' => false,
			'categories' => array( 'vw-taxi-booking-query' ),
		),
		'post-listing-three-column' => array(
			'title'    => __( 'Post Three Column', 'vw-taxi-booking' ),
			//'inserter' => false,
			'categories' => array( 'vw-taxi-booking-query' ),
		),
		'post-listing-four-column' => array(
			'title'    => __( 'Post Four Column', 'vw-taxi-booking' ),
			//'inserter' => false,
			'categories' => array( 'vw-taxi-booking-query' ),
		),
		'feature-post-column' => array(
			'title'    => __( 'Feature Post Column', 'vw-taxi-booking' ),
			//'inserter' => false,
			'categories' => array( 'vw-taxi-booking-query' ),
		),
		'comment-section-1' => array(
			'title'    => __( 'Comment Section 1', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-comment-sections' ),
		),
		'cover-with-post-title' => array(
			'title'    => __( 'Cover With Post Title', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-banner-sections' ),
		),
		'cover-with-search-title' => array(
			'title'    => __( 'Cover With Search Title', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-banner-sections' ),
		),
		'cover-with-archive-title' => array(
			'title'    => __( 'Cover With Archive Title', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-banner-sections' ),
		),
		'cover-with-index-title' => array(
			'title'    => __( 'Cover With Index Title', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-banner-sections' ),
		),
		'theme-button' => array(
			'title'    => __( 'Theme Button', 'vw-taxi-booking' ),
			'categories' => array( 'vw-taxi-booking-theme-button' ),
		),
	);

	$block_pattern_categories = array(
		'vw-taxi-booking-footers' => array( 'label' => __( 'Footers', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-headers' => array( 'label' => __( 'Headers', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-pages'   => array( 'label' => __( 'Pages', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-query'   => array( 'label' => __( 'Query', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-sidebars'   => array( 'label' => __( 'Sidebars', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-home-slider'   => array( 'label' => __( 'Home Slider', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-our-taxis-section'   => array( 'label' => __( 'Our Taxis Section', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-experience-section'   => array( 'label' => __( 'Experience Section', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-testimonial-section'   => array( 'label' => __( 'Testimonial Section', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-news-section'   => array( 'label' => __( 'News Section', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-faq-section'   => array( 'label' => __( 'FAQ Section', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-comment-section'   => array( 'label' => __( 'Comment Sections', 'vw-taxi-booking' ) ),
		'vw-taxi-booking-theme-button'   => array( 'label' => __( 'Theme Button Sections', 'vw-taxi-booking' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since VW Taxi Booking 1.0
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 *     @type array[] $properties {
	 *         An array of block category properties.
	 *
	 *         @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 */
	$block_pattern_categories = apply_filters( 'vw_taxi_booking_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	/**
	 * Filters the theme block patterns.
	 *
	 * @since VW Taxi Booking 1.0
	 *
	 * @param array $block_patterns List of block patterns by name.
	 */
	$patterns = apply_filters( 'vw_taxi_booking_block_patterns', $patterns );

	foreach ( $patterns as $block_pattern => $pattern ) {
		$pattern['content'] = vw_taxi_booking_get_pattern_content( $block_pattern );
		register_block_pattern(
			'vw-taxi-booking/' . $block_pattern,
			$pattern
		);
	}
}
add_action( 'init', 'vw_taxi_booking_register_block_patterns', 9 );
