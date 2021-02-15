<?php
/**
 * Plugin Name: Niche Hero
 * Plugin URI: https://github.com/dallasrowling/niche-hero
 * Description: Niche Hero provides the blog hero section.
 * Version: 1.0.0
 * Author: Dallas Rowling
 * Author URI: https://github.com/dallasrowling
 */
 
/* NICHE HERO CONTENT */
function niche_hero_shortcode( $atts = array() ) {
	extract(shortcode_atts(array(
		'number_of_posts' => '6',
		'post_type' => 'post',
		'box_shadow_in_lead' => '',
		'text_shadow_in_lead' => '',
		'meta_bg_in_lead' => '',
		'border_radius_in_lead' => '',
		'video_views_enabled' => 0,
		'show_date_in_lead' => 0,
		'border_radius' => '',
		'show_date' => 1,
		'show_author' => 0,
		'order_by' => 'DESC',
		'comments_enabled' => 0,
		'overlay_color' => 'rgba(55,55,255,0.3)',
		'second_overlay_color' => 'rgba(55,55,255,0.3)',
		'third_overlay_color' => 'rgba(55,55,255,0.3)',
		'display' => '1',
		'image_height' => '140px',
		'min_height' => '220px',
		'columns' => '4',
		'post_offset' => '0',
		'post_status' => 'publish',
	), $atts));
	$unique_id = wp_unique_id();
	$unique_shortcode_id = 'nh-id-' . ($unique_id - 1);
	$s .= '<section class="niche-hero nh-'.$display.'">';
	$s .= '<ul class="niche-posts">';
	$recent_posts = wp_get_recent_posts(array( 'numberposts' => $number_of_posts, 'order' => $order_by, 'post_type' => $post_type, 'offset' => $post_offset, 'post_status' => $post_status));
	foreach($recent_posts as $key => $post){
	//$unique_id++;
	reset($recent_posts);
		/* Size individual post based on column selection */
		if ($columns == '4') {
			$columns = '25%;';
		} else if ( $columns == '3' ) { 
			$columns = '33.3%';
		} else if ( $columns == '2' ) { 
			$columns = '50%';
		}
		/* Video views */
		if ($video_views_enabled==1 && is_plugin_active('post-views-counter/post-views-counter.php')){
			if (pvc_get_post_views($post['ID']) <= 999){
				$nh_post_views = pvc_get_post_views($post['ID']). ' views'; 
			}else if(pvc_get_post_views($post['ID']) >= 1000 && pvc_get_post_views( $post['ID']) <= 999999){
				$nh_post_views = floor(pvc_get_post_views($post['ID'])/1000) . 'K views'; 
			}else if(pvc_get_post_views($post['ID']) >= 1000000 && pvc_get_post_views( $post['ID']) <= 1099999){
				$nh_post_views = floor(pvc_get_post_views($post['ID'])/1000000) . 'M views'; 		
			}else if(pvc_get_post_views($post['ID']) >= 1100000){
				$nh_post_views = number_format(pvc_get_post_views($post['ID'])/1000000, 1) . 'M views'; 				
			}
			$nh_post_views='<span class="nh-video-views">'.$nh_post_views.'</span>';
		}
		/* Comments */
		if ($comments_enabled == 1) {
			$nh_comments = '<span class="nh-comment-number"><i class="nh-comment-icon"></i>'.get_comments_number($post['ID']).'</span>';
		}
		/* Customize options for leading posts meta */
		if ($key == 0){
			$meta_lead_styling .= '<style type="text/css">';
				if ($meta_bg_in_lead != ''){
				/* META & DATE BG COLOR IN LEAD */ 
				$meta_lead_styling .= '.first-niche-post.'.$unique_shortcode_id.' .nh-date, .first-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';
				$meta_lead_styling .= '.second-niche-post.'.$unique_shortcode_id.' .nh-date, .second-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';
				$meta_lead_styling .= '.third-niche-post.'.$unique_shortcode_id.' .nh-date, .third-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';				
				} 
				if ($text_shadow_in_lead != ''){
				/* TEXT SHADOW IN LEAD */ 
				$meta_lead_styling .= '.first-niche-post.'.$unique_shortcode_id.' .nh-date, .first-niche-post.'.$unique_shortcode_id.' .nh-title h4, .first-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';
				$meta_lead_styling .= '.second-niche-post.'.$unique_shortcode_id.' .nh-date, .second-niche-post.'.$unique_shortcode_id.' .nh-title h4, .second-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';				
				$meta_lead_styling .= '.third-niche-post.'.$unique_shortcode_id.' .nh-date, .third-niche-post.'.$unique_shortcode_id.' .nh-title h4, .third-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';								
				}
				if ($border_radius_in_lead != ''){
				$meta_lead_styling .= '.first-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .first-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .first-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
				$meta_lead_styling .= '.second-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .second-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .second-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
				$meta_lead_styling .= '.third-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .third-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .third-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
				}
				if ($border_radius != ''){
				$meta_lead_styling .= 'li.niche-post.'.$unique_shortcode_id.' .nh-post-thumbnail, li.niche-post.'.$unique_shortcode_id.' .nh-default-thumbnail { border-radius: '.$border_radius.' !important;}';
				}				
			$meta_lead_styling .= '</style>';
		}
		echo $meta_lead_styling;
		/* Combine post meta values */
		$nh_meta = '<div class="nh-meta">'.$nh_post_views . $nh_comments.'</div>';		
		/* Title */
		$nh_title = '<div class="nh-title"><h4>'.$post['post_title'] .'</h4></div>';
		/* Date */
		if($show_date && ($display == 1 && $key != 0 && $key != 1) || $display == 3 || ($display == 2 && $key != 0 && $key != 1 && $key != 2)){
			$nh_date = '<div class="nh-date">'.get_the_date( 'F j, Y', $post['ID']).'</div>';
		} else if ($show_date_in_lead == 1){
			$nh_date = '<div class="nh-date">'.get_the_date( 'F j, Y', $post['ID']).'</div>';			
		}
		/* Fetch post thumbnail or placeholder image */
		if(has_post_thumbnail($post['ID'])){
			$nh_post_thumbnail = get_the_post_thumbnail_url($post['ID'],'full'); 
		} else { 
			$nh_post_thumbnail = '<div class="nh-bg-placeholder" style="height:'.$image_height.';background:url('.plugin_dir_url( __FILE__ ).'assets/images/260x150.png)"></div>'; 
		}
		/* Add all values together */
		if (($show_author == 1) && ($display == 1 && $key != 0 && $key != 1) || $display == 3 || ($display == 2 && $key != 0 && $key != 1 && $key != 2)) {
			$nh_detailed  = '<a href="'.get_permalink($post['ID']).'" class="nh-details"><div class="nh-avatar-box"><img src="'.get_avatar_url($post['ID'], ['size' => '300']).'"/></div><div class="nh-content">'. $nh_date . $nh_title . $nh_meta .'</div></a>';
		} else {
			$nh_detailed  = '<a href="'.get_permalink($post['ID']).'" class="nh-details">' . $nh_date . $nh_title . $nh_meta .'</a>';
		}
		/* Display section #1: Two hero boxes */
		if ($display == '1') {
			if($key === key($recent_posts)) { 
				$s .= '<li class="'.$unique_shortcode_id.' first-niche-post"><span style="background:'.$overlay_color.'" class="niche-overlay"></span>'; 
			}else if($key===1){ 
				$s .= '<li class="'.$unique_shortcode_id.' second-niche-post"><span style="background: '.$second_overlay_color.'" class="niche-overlay"></span>'; 
			}else{
				$s .= '<li class="'.$unique_shortcode_id.' niche-post" style="min-height:'.$min_height.';width:'.$columns.'">'; 
			}
			/* Display post thumbnail or placeholder image */
			if(has_post_thumbnail($post['ID'])){
				if (($key === key($recent_posts) || $key === 1) && $box_shadow_in_lead != '' ){
					$s .= '<a class="nh-post-thumbnail" style="box-shadow: '.$box_shadow_in_lead.' !important;background: url('.$nh_post_thumbnail.'); background-position: center; background-size: cover;" href="'.get_permalink($post['ID']).'">'; 				
				} else {
					$s .= '<a class="nh-post-thumbnail" style="background: url('.$nh_post_thumbnail.'); background-position: center; background-size: cover;" href="'.get_permalink($post['ID']).'">'; 
				}
			}else{ 
				$s .= '<a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail; 
			}
			$s .= '</a>';			
			$s .= $nh_detailed;
			$s .= '</li>';		
		/* Display section #2: Three hero boxes */
		} else if ($display == '2') {
			if ($key === key($recent_posts)){
				$s .= '<li style="width:33.3%;" class="'.$unique_shortcode_id.' first-niche-post"><span style="background:'.$overlay_color.'" class="niche-overlay"></span>'; 
			} else if ( $key === 1 ) { 
				$s .= '<li style="width:33.3%;" class="'.$unique_shortcode_id.' second-niche-post"><span style="background:'.$second_overlay_color.'" class="niche-overlay"></span>'; 
			} else if ( $key === 2 ) {
				$s .= '<li style="width:33.3%;" class="'.$unique_shortcode_id.' third-niche-post"><span style="background:'.$third_overlay_color.'" class="niche-overlay"></span>'; 
			} else { 
				$s .= '<li class="niche-post" style="width:'.$columns.'">'; 
			} 
			if(has_post_thumbnail($post['ID'])){
				if (($key === key($recent_posts) || $key === 1 || $key === 2) && $box_shadow_in_lead != '' ){
					$s .= '<a class="nh-post-thumbnail" style="box-shadow: '.$box_shadow_in_lead.';background: url('.$nh_post_thumbnail.'); background-position: center; background-size: cover;" href="'.get_permalink($post['ID']).'">'; 				
				} else {
					$s .= '<a class="nh-post-thumbnail" style="background: url('.$nh_post_thumbnail.'); background-position: center; background-size: cover;" href="'.get_permalink($post['ID']).'">'; 
				}
			}else{ 
				$s .= '<a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail; 
			}
			$s .= '</a>';
			$s .= $nh_detailed;
			$s .= '</li>';	
			/* Display section #3: Hero list */
			} else if ($display == '3') {
					$s .= '<li class="niche-post" style="min-height: '.$min_height.'; width:'.$columns.';">'; 
						if($columns=='50%'){
							if (has_post_thumbnail($post['ID'])){
								$s .= '<a class="nh-post-thumbnail" style="padding-top: '.$image_height.'; height:'.$image_height.'; background: url('.$nh_post_thumbnail.'); background-position: center; background-size: cover;" href="'.get_permalink($post['ID']).'"></a>';
							}else{
								$s .= '<a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail.'</a>';
							}						
							$s .= $nh_detailed;
						}else{
							if (has_post_thumbnail($post['ID'])){
								$s .= '<a class="nh-post-thumbnail" style="padding-top: '.$image_height.'; height:'.$image_height.'; background: url('.$nh_post_thumbnail.'); background-position: center; background-size: cover;" href="'.get_permalink($post['ID']).'"></a>'; 
							} else { 
								$s .= '<a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail.'</a>'; 
							}
							$s .= $nh_detailed;
						}
					$s .= '</li>';						
			}
		}
		$s .= '</ul>';
		$s .= '</section>';
		return $s; 
}
/* NICHE HERO SHORTCODE REGISTRATION */
add_shortcode('nichehero','niche_hero_shortcode');

/* Registrate Niche Hero Stylesheet */
function niche_hero_add_stylesheet() {
    wp_enqueue_style( 'niche-hero-css', plugins_url( '/assets/css/style.css', __FILE__ ) );
	if (get_theme_mod('nh_enable_font_awesome') == 'enable') {
		wp_enqueue_style( 'niche-hero-font-awesome-css', plugins_url( '/assets/css/all.min.css', __FILE__ ) );
	}
	if (get_theme_mod('nh_select_google_font') == 'Roboto') {
		wp_enqueue_style( 'google-font-import-roboto', 'https://fonts.googleapis.com/css2?family=Roboto&display=swap' );	
	} else if (get_theme_mod('nh_select_google_font') == 'Open Sans') {
		wp_enqueue_style( 'google-font-import-open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans&display=swap' );		
	} else if (get_theme_mod('nh_select_google_font') == 'Lato') {
		wp_enqueue_style( 'google-font-import-lato', 'https://fonts.googleapis.com/css2?family=Lato&display=swap' );
	}
}

function niche_hero_inline_css() {
	    $google_font = get_theme_mod( 'nh_select_google_font' );
	    $custom_css = "<style type=\"text/css\">
		li.niche-post div.nh-date,
		li.first-niche-post div.nh-date,
		li.second-niche-post div.nh-date,
		li.third-niche-post div.nh-date,
		li.niche-post span.nh-video-views,
		li.first-niche-post span.nh-video-views,
		li.second-niche-post span.nh-video-views,
		li.third-niche-post span.nh-video-views,
		li.first-niche-post div.nh-title h4,
		li.niche-post span.nh-comment-number,
		li.first-niche-post span.nh-comment-number,
		li.second-niche-post div.nh-title h4,
		li.second-niche-post span.nh-comment-number,
		li.third-niche-post div.nh-title h4,
		li.third-niche-post span.nh-comment-number,
		li.niche-post div.nh-title h4
		{ font-family: $google_font !important; }</style>";
        echo $custom_css;
}
add_action( 'wp_head', 'niche_hero_inline_css' );

/* Prioritize loading of stylesheet at load with 1 */
add_action('wp_head', 'niche_hero_add_stylesheet', 1);

function niche_hero_plugin_customizer( $wp_customize ) {
		
		/* Add Niche Hero */
		$wp_customize->add_section(
			'niche_hero_section',
			array(
				'title'      => __( 'Niche Hero', 'globestar' ),
				'priority'   => 9999,
				'capability' => 'edit_theme_options',
			)
		); 
		
		$wp_customize->add_setting(
			'nh_enable_font_awesome',
			array(
				'default' => 'disable',
			)
		);
		$wp_customize->add_control(
			'nh_enable_font_awesome',
			array(
				'type' => 'radio',
				'label' => 'Enable Font Awesome',
				'description' => 'Enable this setting to allow "Niche Hero" to load font awesome. If there is another plugin or theme loading it already, it may result in undesirable results.',
				'section' => 'niche_hero_section',
				'choices' => array(
					'enable' => 'Enable',
					'disable' => 'Disable',
				),
			)
		);
		$wp_customize->add_setting(
			'nh_select_google_font',
			array(
				'default' => 'Roboto',
			)
		);
		$wp_customize->add_control(
			'nh_select_google_font',
			array(
				'type' => 'select',
				'label' => 'Google font selection',
				'description' => 'Select the Google font that will be utilized to style all "Niche Hero" text elements',
				'section' => 'niche_hero_section',
				'choices' => array(
					'no_google_font' => 'No Google font',				
					'Roboto' => 'Roboto',
					'Open Sans' => 'Open Sans',
					'Lato' => 'Lato',
				),
			)
		);
}
add_action( 'customize_register', 'niche_hero_plugin_customizer' );
