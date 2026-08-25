<?php
/**
 * Title: Testimonial Section
 * Slug: vw-taxi-booking/testimonial-section
 * Categories: template
 */
?>
<!-- wp:group {"className":"testimonial-section","style":{"spacing":{"padding":{"right":"0px","left":"0px","top":"0px","bottom":"0px"},"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"constrained","contentSize":""}} -->
<div class="wp-block-group testimonial-section" style="margin-top:0px;margin-bottom:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:cover {"url":"<?php echo esc_url(get_template_directory_uri()); ?>/images/testimonial-banner.png","id":46,"dimRatio":70,"overlayColor":"secondary","isUserOverlayColor":true,"sizeSlug":"large","style":{"spacing":{"padding":{"right":"0px","left":"0px","top":"70px","bottom":"70px"}}},"layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-cover" style="padding-top:70px;padding-right:0px;padding-bottom:70px;padding-left:0px"><img class="wp-block-cover__image-background wp-image-46 size-large" alt="" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/testimonial-banner.png" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:columns {"className":"testimonial-heading-box wow fadeInDown"} -->
<div class="wp-block-columns testimonial-heading-box wow fadeInDown"><!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%","className":"testimonial-heading-cont","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|40"}}}} -->
<div class="wp-block-column testimonial-heading-cont" style="padding-bottom:var(--wp--preset--spacing--40);flex-basis:50%"><!-- wp:paragraph {"align":"center","className":"testimonial-small-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"textTransform":"capitalize","fontStyle":"thin","fontWeight":"600","fontSize":"16px"},"spacing":{"padding":{"top":"0px","bottom":"0px","left":"12px","right":"12px"},"margin":{"bottom":"var:preset|spacing|20"}}},"textColor":"primary","fontFamily":"outfit"} -->
<p class="has-text-align-center testimonial-small-title has-primary-color has-text-color has-link-color has-outfit-font-family" style="margin-bottom:var(--wp--preset--spacing--20);padding-top:0px;padding-right:12px;padding-bottom:0px;padding-left:12px;font-size:16px;font-style:thin;font-weight:600;text-transform:capitalize"><?php echo esc_html__('testimonials', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":4,"style":{"typography":{"textTransform":"capitalize","fontSize":"28px","fontStyle":"thin","fontWeight":"700"},"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0"}},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background","fontFamily":"outfit"} -->
<h4 class="wp-block-heading has-text-align-center has-background-color has-text-color has-link-color has-outfit-font-family" style="margin-top:var(--wp--preset--spacing--30);margin-bottom:0;font-size:28px;font-style:thin;font-weight:700;text-transform:capitalize"><?php echo esc_html__('what our customers are saying', 'vw-taxi-booking'); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"15px"},"spacing":{"margin":{"top":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background","fontFamily":"outfit"} -->
<p class="has-text-align-center has-background-color has-text-color has-link-color has-outfit-font-family" style="margin-top:var(--wp--preset--spacing--20);font-size:15px"><?php echo esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"owl-carousel  wow fadeInUp","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group owl-carousel wow fadeInUp" style="margin-top:var(--wp--preset--spacing--70)"><!-- wp:group {"className":"client-box","style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"bottom":"45px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group client-box" style="padding-bottom:45px"><!-- wp:cover {"overlayColor":"background","isUserOverlayColor":true,"minHeight":200,"isDark":false,"className":"testimonial-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light testimonial-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60);min-height:200px"><span aria-hidden="true" class="wp-block-cover__background has-background-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"extra-small","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family has-extra-small-font-size"><?php echo esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lobortis laoreet ante, ut rutrum felis tincidunt vel. Proin tellus magna, malesuada sit amet justo non, interdum congue tortor. Donec volutpat sollicitudin urna consequat luctus.', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":5,"style":{"typography":{"textTransform":"capitalize","fontSize":"22px"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"outfit"} -->
<h5 class="wp-block-heading has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0px;font-size:22px;text-transform:capitalize"><?php echo esc_html__('ruth polina', 'vw-taxi-booking'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"0px","bottom":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontSize":"15px","textTransform":"capitalize"}},"textColor":"secondary","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0px;margin-bottom:var(--wp--preset--spacing--50);font-size:15px;text-transform:capitalize"><?php echo esc_html__('sales associate', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->

<!-- wp:image {"id":466,"width":"80px","height":"80px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","className":"client-img","style":{"border":{"radius":"50px","width":"4px"}},"borderColor":"foreground"} -->
<figure class="wp-block-image aligncenter size-full is-resized has-custom-border client-img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/client1.png" alt="" class="has-border-color has-foreground-border-color wp-image-466" style="border-width:4px;border-radius:50px;object-fit:cover;width:80px;height:80px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"client-box","style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"bottom":"45px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group client-box" style="padding-bottom:45px"><!-- wp:cover {"overlayColor":"background","isUserOverlayColor":true,"minHeight":200,"isDark":false,"className":"testimonial-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light testimonial-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60);min-height:200px"><span aria-hidden="true" class="wp-block-cover__background has-background-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"extra-small","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family has-extra-small-font-size"><?php echo esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lobortis laoreet ante, ut rutrum felis tincidunt vel. Proin tellus magna, malesuada sit amet justo non, interdum congue tortor. Donec volutpat sollicitudin urna consequat luctus.', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":5,"style":{"typography":{"textTransform":"capitalize","fontSize":"22px"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"outfit"} -->
<h5 class="wp-block-heading has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0px;font-size:22px;text-transform:capitalize"><?php echo esc_html__('john wick', 'vw-taxi-booking'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"0px","bottom":"var:preset|spacing|50"}},"typography":{"fontSize":"15px","textTransform":"capitalize"},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0px;margin-bottom:var(--wp--preset--spacing--50);font-size:15px;text-transform:capitalize"><?php echo esc_html__('retail specialist', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->

<!-- wp:image {"id":481,"width":"80px","height":"80px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","className":"client-img","style":{"border":{"radius":"50px","width":"4px"}},"borderColor":"foreground"} -->
<figure class="wp-block-image aligncenter size-full is-resized has-custom-border client-img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/client2.png" alt="" class="has-border-color has-foreground-border-color wp-image-481" style="border-width:4px;border-radius:50px;object-fit:cover;width:80px;height:80px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"client-box","style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"bottom":"45px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group client-box" style="padding-bottom:45px"><!-- wp:cover {"overlayColor":"background","isUserOverlayColor":true,"minHeight":200,"isDark":false,"className":"testimonial-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light testimonial-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60);min-height:200px"><span aria-hidden="true" class="wp-block-cover__background has-background-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"extra-small","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family has-extra-small-font-size"><?php echo esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lobortis laoreet ante, ut rutrum felis tincidunt vel. Proin tellus magna, malesuada sit amet justo non, interdum congue tortor. Donec volutpat sollicitudin urna consequat luctus.', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":5,"style":{"typography":{"textTransform":"capitalize","fontSize":"22px"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"outfit"} -->
<h5 class="wp-block-heading has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0px;font-size:22px;text-transform:capitalize"><?php echo esc_html__('sophia james', 'vw-taxi-booking'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"0px","bottom":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontSize":"15px","textTransform":"capitalize"}},"textColor":"secondary","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0px;margin-bottom:var(--wp--preset--spacing--50);font-size:15px;text-transform:capitalize"><?php echo esc_html__('studio executive', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->

<!-- wp:image {"id":482,"width":"80px","height":"80px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","className":"client-img","style":{"border":{"radius":"50px","width":"4px"}},"borderColor":"foreground"} -->
<figure class="wp-block-image aligncenter size-full is-resized has-custom-border client-img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/client3.png" alt="" class="has-border-color has-foreground-border-color wp-image-482" style="border-width:4px;border-radius:50px;object-fit:cover;width:80px;height:80px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"client-box","style":{"dimensions":{"minHeight":""},"spacing":{"padding":{"bottom":"45px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group client-box" style="padding-bottom:45px"><!-- wp:cover {"overlayColor":"background","isUserOverlayColor":true,"minHeight":200,"isDark":false,"className":"testimonial-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|60","right":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light testimonial-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--60);min-height:200px"><span aria-hidden="true" class="wp-block-cover__background has-background-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontSize":"extra-small","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family has-extra-small-font-size"><?php echo esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam lobortis laoreet ante, ut rutrum felis tincidunt vel. Proin tellus magna, malesuada sit amet justo non, interdum congue tortor. Donec volutpat sollicitudin urna consequat luctus.', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":5,"style":{"typography":{"textTransform":"capitalize","fontSize":"22px"},"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"outfit"} -->
<h5 class="wp-block-heading has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0px;font-size:22px;text-transform:capitalize"><?php echo esc_html__('Liam Alexander', 'vw-taxi-booking'); ?></h5>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"0px","bottom":"var:preset|spacing|50"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontSize":"15px","textTransform":"capitalize"}},"textColor":"secondary","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0px;margin-bottom:var(--wp--preset--spacing--50);font-size:15px;text-transform:capitalize"><?php echo esc_html__('Business Analyst', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->

<!-- wp:image {"id":483,"width":"80px","height":"80px","scale":"cover","sizeSlug":"full","linkDestination":"none","align":"center","className":"client-img","style":{"border":{"radius":"50px","width":"4px"}},"borderColor":"foreground"} -->
<figure class="wp-block-image aligncenter size-full is-resized has-custom-border client-img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/client4.png" alt="" class="has-border-color has-foreground-border-color wp-image-483" style="border-width:4px;border-radius:50px;object-fit:cover;width:80px;height:80px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->