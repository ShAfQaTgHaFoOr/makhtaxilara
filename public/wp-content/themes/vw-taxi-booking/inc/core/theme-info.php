<?php
/**
 * Add theme page
 */

function vw_taxi_booking_menu() {
	add_theme_page( esc_html__( 'VW Taxi Booking', 'vw-taxi-booking' ), esc_html__( 'VW Taxi Booking Theme', 'vw-taxi-booking' ), 'edit_theme_options', 'vw-taxi-booking-info', 'vw_taxi_booking_theme_page_display' );
}
add_action( 'admin_menu', 'vw_taxi_booking_menu' );

function vw_taxi_booking_admin_theme_style() {
	wp_enqueue_style('vw-taxi-booking-custom-admin-style', esc_url(get_template_directory_uri()) . '/css/admin-style.css');
	wp_enqueue_script('vw-taxi-booking-tabs', esc_url(get_template_directory_uri()) . '/js/tab.js');
}
add_action('admin_enqueue_scripts', 'vw_taxi_booking_admin_theme_style');

/**
 * Display About page
 */
function vw_taxi_booking_theme_page_display() {
	$vw_taxi_booking_theme = wp_get_theme();

	if ( is_child_theme() ) {
		$vw_taxi_booking_theme = wp_get_theme()->parent();
	} ?>

	<div class="wrapper-info">
	    <div class="col-left sshot-section">
	    	<h2><?php esc_html_e( 'Welcome to VW Taxi Booking Theme', 'vw-taxi-booking' ); ?> <span class="version"><?php esc_html_e('Version:','vw-taxi-booking'); ?> <?php echo esc_html($vw_taxi_booking_theme['Version']);?></span></h2>
	    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','vw-taxi-booking'); ?></p>
	    </div>
	    <div class="col-right coupen-section">
			<div class="logo-section">
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="" />
			</div>
			<div class="logo-right">            
	            <div class="update-now">
	                <div class="theme-info">
	                    <div class="theme-info-left">
	                        <h2><?php esc_html_e('TRY PREMIUM','vw-taxi-booking'); ?></h2>
	                        <h4><?php esc_html_e('VW Taxi Booking THEME','vw-taxi-booking'); ?></h4>
	                    </div>    
	                    <div class="theme-info-right"></div>
	                </div>    
	                <div class="dicount-row">
	                    <div class="disc-sec">    
	                        <h5 class="disc-text"><?php esc_html_e('GET THE FLAT DISCOUNT OF','vw-taxi-booking'); ?></h5>
	                        <h1 class="disc-per"><?php esc_html_e('20%','vw-taxi-booking'); ?></h1>    
	                    </div>
	                    <div class="coupen-info">
	                        <h5 class="coupen-code"><?php esc_html_e('"VWPRO20"','vw-taxi-booking'); ?></h5>
	                        <h5 class="coupen-text"><?php esc_html_e('USE COUPON CODE','vw-taxi-booking'); ?></h5>
	                        <div class="info-link">                        
	                            <a href="<?php echo esc_url( VW_TAXI_BOOKING_BUY_NOW ); ?>" target="_blank"> <?php esc_html_e( 'UPGRADE TO PRO', 'vw-taxi-booking' ); ?></a>
	                        </div>    
	                    </div>    
	                </div>                
	            </div>
	        </div> 
	    </div>

	    <div class="tab-sec">
			<div class="tab">
				<button class="tablinks" onclick="vw_taxi_booking_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Free Setup', 'vw-taxi-booking' ); ?></button>
			  	<button class="tablinks" onclick="vw_taxi_booking_open_tab(event, 'pro_theme')"><?php esc_html_e( 'Get Premium', 'vw-taxi-booking' ); ?></button>
			  	<button class="tablinks" onclick="vw_taxi_booking_open_tab(event, 'free_pro')"><?php esc_html_e( 'Free Vs Premium', 'vw-taxi-booking' ); ?></button>
			  	<button class="tablinks" onclick="vw_taxi_booking_open_tab(event, 'get_bundle')"><?php esc_html_e( 'Get 350+ Themes Bundle at $99', 'vw-taxi-booking' ); ?></button>
			</div>

			<div id="lite_theme" class="tabcontent open">
				<div class="lite-theme-tab">
					<h3><?php esc_html_e( 'Lite Theme Information', 'vw-taxi-booking' ); ?></h3>
					<hr class="h3hr">
				  	<p><?php esc_html_e('Take your taxi business online with the VW Taxi Booking Theme, crafted specifically for cab companies, ride-hailing services, car rental businesses, airport transfers, and private taxi operators while also supporting ecommerce functionality for selling travel passes, corporate ride packages, and online booking services through WooCommerce, making it suitable for modern digital business setups. This responsive and mobile-friendly theme allows you to create a professional website where customers can book taxis online, schedule rides, manage corporate travel, and choose from multiple vehicles effortlessly, helping you scale like other successful online booking platforms. Its clean design and intuitive layout make navigation smooth for users searching for taxi booking, cab booking, airport pickups, and local ride services, while SEO-friendly structure and Yoast SEO compatibility enhance search visibility to attract more clients. Pre-built pages allow you to showcase fleets, driver profiles, fare calculator, instant reservations, and secure online payments, and Contact Form 7 integration ensures efficient customer inquiries and booking confirmations. With real-time availability updates, flexible ride scheduling, speed-optimized performance, and support for page builders for easy customization, the VW Taxi Booking Theme provides a conversion-focused experience ideal for taxi companies, ride-hailing startups, and transportation service providers. Whether offering city rides, corporate transfers, or airport drop-off services, this feature-rich and user-friendly theme helps streamline taxi service management, boost bookings, and build a strong online presence that drives business growth.','vw-taxi-booking'); ?></p>
				  	<div class="col-left-inner">
						<div class="pro-links">
					    	<a href="<?php echo esc_url( admin_url() . 'site-editor.php' ); ?>" target="_blank"><?php esc_html_e('Edit Your Site', 'vw-taxi-booking'); ?></a>
							<a href="<?php echo esc_url( home_url() ); ?>" target="_blank"><?php esc_html_e('Visit Your Site', 'vw-taxi-booking'); ?></a>
						</div>
						<div class="support-forum-col-section">
							<div class="support-forum-col">
								<h4><?php esc_html_e('Having Trouble, Need Support?', 'vw-taxi-booking'); ?></h4>
								<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'vw-taxi-booking'); ?></p>
								<div class="info-link">
									<a href="<?php echo esc_url( VW_TAXI_BOOKING_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'vw-taxi-booking'); ?></a>
								</div>
							</div>
							<div class="support-forum-col">
								<h4><?php esc_html_e('Reviews & Testimonials', 'vw-taxi-booking'); ?></h4>
								<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'vw-taxi-booking'); ?>  </p>
								<div class="info-link">
									<a href="<?php echo esc_url( VW_TAXI_BOOKING_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'vw-taxi-booking'); ?></a>
								</div>
							</div>
							<div class="support-forum-col">
								<h4><?php esc_html_e('Theme Documentation', 'vw-taxi-booking'); ?></h4>
								<p> <?php esc_html_e('If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'vw-taxi-booking'); ?>  </p>
								<div class="info-link">
									<a href="<?php echo esc_url( VW_TAXI_BOOKING_FREE_DOC ); ?>" target="_blank"><?php esc_html_e('Free Theme Documentation', 'vw-taxi-booking'); ?></a>
								</div>
							</div>
						</div>
				  	</div>
				</div>
			</div>

			<div id="pro_theme" class="tabcontent">
			  	<h3><?php esc_html_e( 'Premium Theme Information', 'vw-taxi-booking' ); ?></h3>
				<hr class="h3hr">
				<div class="col-left-pro">
	    			<p><?php esc_html_e('The Taxi WordPress Theme is a premium, feature-rich solution designed for taxi services, cab booking agencies, and ride-hailing businesses seeking a professional online presence. With a sleek and modern design, this theme ensures your website is visually appealing, highly responsive, and user-friendly across all devices. Built with the latest WordPress standards and optimized for speed, it allows visitors to easily book rides, view services, and check fare estimates. Its customizable layouts and drag-and-drop page builder compatibility give you full control over every section, enabling you to create a website that perfectly represents your brand. Integrated with WooCommerce and other essential plugins, the theme supports online payments, service management, and promotional offers seamlessly. It also comes with multilingual support and SEO optimization, ensuring your taxi business reaches a broader audience while ranking higher in search results. With dedicated customer support and detailed documentation, even beginners can set up and run a professional online taxi booking website in no time. Whether you are an independent cab owner or a large taxi company, this theme simplifies website management and enhances customer engagement, boosting your business growth.','vw-taxi-booking'); ?></p>
	    		</div>
		    	<div class="col-right-pro">
			    	<div class="pro-links">
				    	<a href="<?php echo esc_url( VW_TAXI_BOOKING_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'vw-taxi-booking'); ?></a>
						<a href="<?php echo esc_url( VW_TAXI_BOOKING_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'vw-taxi-booking'); ?></a>
						<a href="<?php echo esc_url( VW_TAXI_BOOKING_PRO_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'vw-taxi-booking'); ?></a>
						<a href="<?php echo esc_url( VW_TAXI_BOOKING_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Get 350+ Themes Bundle at $99', 'vw-taxi-booking'); ?></a>
					</div>
					<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/pro.png" alt="" />
				</div>
			</div>

			<div id="free_pro" class="tabcontent">
				<div class="featurebox">
				    <h3 class="theme-features"><?php esc_html_e( 'Theme Features', 'vw-taxi-booking' ); ?></h3>
					<hr class="h3hr1">
					<div class="table-image">
						<table class="tablebox">
							<thead>
								<tr>
									<th><?php esc_html_e('Features', 'vw-taxi-booking'); ?></th>
									<th><?php esc_html_e('Free Themes', 'vw-taxi-booking'); ?></th>
									<th><?php esc_html_e('Premium Themes', 'vw-taxi-booking'); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?php esc_html_e('Easy Setup', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Responsive Design', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('SEO Friendly', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Banner Settings', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Template Pages', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><?php esc_html_e('1', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><?php esc_html_e('14', 'vw-taxi-booking'); ?></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Home Page Template', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><?php esc_html_e('1', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><?php esc_html_e('1', 'vw-taxi-booking'); ?></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Theme sections', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><?php esc_html_e('2', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><?php esc_html_e('12', 'vw-taxi-booking'); ?></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Contact us Page Template', 'vw-taxi-booking'); ?></td>
									<td class="table-img">0</td>
									<td class="table-img"><?php esc_html_e('1', 'vw-taxi-booking'); ?></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Blog Templates & Layout', 'vw-taxi-booking'); ?></td>
									<td class="table-img">0</td>
									<td class="table-img"><?php esc_html_e('3(Full width/Left/Right Sidebar)', 'vw-taxi-booking'); ?></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Section Reordering', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Demo Importer', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Full Documentation', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Latest WordPress Compatibility', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Support 3rd Party Plugins', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Secure and Optimized Code', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Exclusive Functionalities', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Section Enable / Disable', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Section Google Font Choices', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Gallery', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Simple & Mega Menu Option', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Support to add custom CSS / JS ', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Shortcodes', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Custom Background, Colors, Header, Logo & Menu', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Premium Membership', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Budget Friendly Value', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Priority Error Fixing', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Custom Feature Addition', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('All Access Theme Pass', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Seamless Customer Support', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('WordPress 6.4 or later', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('PHP 8.2 or 8.3', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('MySQL 5.6 (or greater) | MariaDB 10.0 (or greater)', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Influence Registration', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr class="odd">
									<td><?php esc_html_e('Detailed Influencer Portfolio', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
									<td><?php esc_html_e('Premium Pricing Plan', 'vw-taxi-booking'); ?></td>
									<td class="table-img"><span class="dashicons dashicons-no"></span></td>
									<td class="table-img"><span class="dashicons dashicons-saved"></span></td>
								</tr>
								<tr>
								<td></td>
								<td class="table-img"></td>
								<td class="update-link"><a href="<?php echo esc_url( VW_TAXI_BOOKING_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade to Pro', 'vw-taxi-booking'); ?></a></td>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<div id="get_bundle" class="tabcontent">		  	
			   <div class="col-left-pro">
			   	<h3><?php esc_html_e( 'WP Theme Bundle', 'vw-taxi-booking' ); ?></h3>
			    	<p><?php esc_html_e('Enhance your website effortlessly with our WP Theme Bundle. Get access to 350+ premium WordPress themes and 5+ powerful plugins, all designed to meet diverse business needs. Enjoy seamless integration with any plugins, ultimate customization flexibility, and regular updates to keep your site current and secure. Plus, benefit from our dedicated customer support, ensuring a smooth and professional web experience.','vw-taxi-booking'); ?></p>
			    	<div class="feature">
			    		<h4><?php esc_html_e( 'Features:', 'vw-taxi-booking' ); ?></h4>
			    		<p><?php esc_html_e('350+ Premium Themes & 5+ Plugins.', 'vw-taxi-booking'); ?></p>
			    		<p><?php esc_html_e('Seamless Integration.', 'vw-taxi-booking'); ?></p>
			    		<p><?php esc_html_e('Customization Flexibility.', 'vw-taxi-booking'); ?></p>
			    		<p><?php esc_html_e('Regular Updates.', 'vw-taxi-booking'); ?></p>
			    		<p><?php esc_html_e('Dedicated Support.', 'vw-taxi-booking'); ?></p>
			    	</div>
			    	<p>Upgrade now and give your website the professional edge it deserves, all at an unbeatable price of $99!</p>
			    	<div class="pro-links">
						<a href="<?php echo esc_url( VW_TAXI_BOOKING_THEME_BUNDLE_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Now', 'vw-taxi-booking'); ?></a>
						<a href="<?php echo esc_url( VW_TAXI_BOOKING_THEME_BUNDLE_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation', 'vw-taxi-booking'); ?></a>
					</div>
			   </div>
			   <div class="col-right-pro">
			    	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/bundle.png" alt="" />
			   </div>		    
			</div>
		</div>
	</div>
<?php }?>
