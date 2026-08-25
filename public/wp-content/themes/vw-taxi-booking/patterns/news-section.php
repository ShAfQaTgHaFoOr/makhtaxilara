<?php
/**
 * Title: News Section
 * Slug: vw-taxi-booking/news-section
 * Categories: template
 */
?>
<!-- wp:group {"className":"news-section","style":{"spacing":{"margin":{"top":"0px","bottom":"0px"},"padding":{"top":"0rem","bottom":"0rem"}}},"layout":{"type":"constrained","contentSize":"80%"}} -->
<div class="wp-block-group news-section" style="margin-top:0px;margin-bottom:0px;padding-top:0rem;padding-bottom:0rem"><!-- wp:columns {"className":"news-heading-box wow fadeInDown","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns news-heading-box wow fadeInDown" style="margin-bottom:var(--wp--preset--spacing--70)"><!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%","className":"news-heading-inner-box"} -->
<div class="wp-block-column news-heading-inner-box" style="flex-basis:50%"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","className":"news-sub-title","style":{"typography":{"fontSize":"17px","fontStyle":"thin","fontWeight":"500","textTransform":"capitalize"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"padding":{"right":"12px","left":"12px"}}},"textColor":"primary","fontFamily":"outfit"} -->
<p class="has-text-align-center news-sub-title has-primary-color has-text-color has-link-color has-outfit-font-family" style="padding-right:12px;padding-left:12px;font-size:17px;font-style:thin;font-weight:500;text-transform:capitalize"><?php echo esc_html__('news & blog', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":4,"className":"news-sec-heading","style":{"typography":{"textTransform":"capitalize","fontSize":"28px"},"spacing":{"margin":{"top":"var:preset|spacing|30","bottom":"0rem"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary","fontFamily":"outfit"} -->
<h4 class="wp-block-heading has-text-align-center news-sec-heading has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:var(--wp--preset--spacing--30);margin-bottom:0rem;font-size:28px;text-transform:capitalize"><?php echo esc_html__('our latest news & blogs', 'vw-taxi-booking'); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontSize":"15px","lineHeight":1.4},"spacing":{"margin":{"top":"12px"}}},"textColor":"secondary","fontFamily":"outfit"} -->
<p class="has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:12px;font-size:15px;line-height:1.4"><?php echo esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin nisi elit, consequat pharetra elementum nec, eleifend non turpis.', 'vw-taxi-booking'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:query {"queryId":11,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[],"format":[]},"metadata":{"categories":["posts"],"patternName":"core/query-standard-posts","name":"Standard"}} -->
<div class="wp-block-query"><!-- wp:post-template {"className":"news-box owl-carousel wow fadeInUp","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"news-img","style":{"dimensions":{"minHeight":"230px"},"border":{"radius":"20px"},"spacing":{"padding":{"top":"0px","bottom":"0px","left":"0px","right":"0px"}},"color":{"background":"#00000069"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group news-img has-background" style="border-radius:20px;background-color:#00000069;min-height:230px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"height":"230px","align":"wide","style":{"border":{"radius":"20px"},"color":[]}} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":5,"isLink":true,"className":"news-box-title","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|20","top":"var:preset|spacing|30"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"fontStyle":"thin","fontWeight":"600"}},"textColor":"secondary","fontFamily":"outfit"} /-->

<!-- wp:post-excerpt {"excerptLength":20,"className":"news-box-desc","style":{"typography":{"fontSize":"15px","lineHeight":1.4},"spacing":{"margin":{"top":"0px","bottom":"5px"}},"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}}},"textColor":"secondary"} /-->

<!-- wp:group {"className":"news-meta","fontFamily":"inter","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group news-meta has-inter-font-family"><!-- wp:post-author-name {"style":{"typography":{"textTransform":"capitalize","lineHeight":"1.2","fontStyle":"normal","fontWeight":"600","fontSize":"15px"},"spacing":{"padding":{"left":"var:preset|spacing|50","top":"3px"}},"elements":{"link":{"color":{"text":"var:preset|color|heading-color"}}}},"textColor":"heading-color"} /-->

<!-- wp:post-date {"style":{"layout":{"selfStretch":"fit","flexSize":null},"spacing":{"padding":{"left":"var:preset|spacing|50","top":"3px"}},"elements":{"link":{"color":{"text":"var:preset|color|heading-color"}}},"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"15px"}},"textColor":"heading-color"} /-->

<!-- wp:comments -->
<div class="wp-block-comments"><!-- wp:comments-title {"showPostTitle":false,"level":6,"style":{"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"15px","textTransform":"capitalize"},"spacing":{"margin":{"top":"0px","bottom":"0px"},"padding":{"left":"var:preset|spacing|50","top":"3px"}},"elements":{"link":{"color":{"text":"var:preset|color|heading-color"}}}},"textColor":"heading-color"} /--></div>
<!-- /wp:comments --></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->