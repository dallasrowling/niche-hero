<?php
/**
 * Plugin Name: Niche Hero
 * Plugin URI: https://github.com/dallasrowling/niche-hero
 * Description: Niche Hero provides the blog hero section.
 * Version: 1.0.5
 * Author: Dallas Rowling
 * Author URI: https://github.com/dallasrowling
 */
 
/* NICHE HERO CONTENT SHORTCODE */
function niche_hero_shortcode( $atts = array() ) {
	extract(shortcode_atts(array(
		'type' => 'standard',
	), $atts ));
	// START TYPE: STANDARD
	if($type == 'standard'){
		extract(shortcode_atts(array(
			'number_of_posts' => '6',
			'spacing' => '0px',
			'post_type' => 'post',
			'box_shadow_in_lead' => '',
			'text_shadow_in_lead' => '',
			'image_height_in_lead' => '300px',				
			'meta_bg_in_lead' => '',
			'column_push' => '',
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
			'post_offset' => '0',
			'columns' => '4',
			'post_status' => 'publish',
		), $atts ));
	$unique_id = wp_unique_id();
	$unique_shortcode_id = 'nh-id-' . ($unique_id - 1);
	$run_loop_once = 0;			
	/* RUN CUSTOM CSS PER NICHE HERO STANDARD INSTANCE (ONLY RUNS ONCE) */	
	while ($run_loop_once == 0 && $key == 0) {
		$niche_hero_section_styling .= '<style type="text/css">';
			/* SPACING */
			if ($spacing != '0px') {
				$niche_hero_section_styling .= '.'.$unique_shortcode_id.'-main { padding: ' . /*$spacing*/ "" .' }';
			}
			/* META & DATE BG COLOR IN LEAD */ 
			if ($meta_bg_in_lead != ''){
				$niche_hero_section_styling .= '.first-niche-post.'.$unique_shortcode_id.' .nh-date, .first-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';
				$niche_hero_section_styling .= '.second-niche-post.'.$unique_shortcode_id.' .nh-date, .second-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';
				$niche_hero_section_styling .= '.third-niche-post.'.$unique_shortcode_id.' .nh-date, .third-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';				
			}
			/* TEXT SHADOW IN LEAD */
			if ($text_shadow_in_lead != ''){ 
				$niche_hero_section_styling .= '.first-niche-post.'.$unique_shortcode_id.' .nh-date, .first-niche-post.'.$unique_shortcode_id.' .nh-title h4, .first-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';
				$niche_hero_section_styling .= '.second-niche-post.'.$unique_shortcode_id.' .nh-date, .second-niche-post.'.$unique_shortcode_id.' .nh-title h4, .second-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';				
				$niche_hero_section_styling .= '.third-niche-post.'.$unique_shortcode_id.' .nh-date, .third-niche-post.'.$unique_shortcode_id.' .nh-title h4, .third-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';								
			}
			/* BORDER RADIUS IN LEAD */
			if ($border_radius_in_lead != ''){
				$niche_hero_section_styling .= '.first-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .first-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .first-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
				$niche_hero_section_styling .= '.second-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .second-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .second-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
				$niche_hero_section_styling .= '.third-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .third-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .third-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
			}
			/* GENERAL BORDER RADIUS */
			if ($border_radius != ''){
				$niche_hero_section_styling .= 'li.niche-post.'.$unique_shortcode_id.' .nh-post-thumbnail, li.niche-post.'.$unique_shortcode_id.' .nh-default-thumbnail { border-radius: '.$border_radius.' !important;}';
			}				
		$niche_hero_section_styling .= '</style>';
		$run_loop_once++;
	}
	echo $niche_hero_section_styling;
	// ATTRIBUTE COLUMN PUSH CLASS
	if ($column_push == 'one-quarter') {
		$column_push = 'column-push-one-quarter';
	} else if ($column_push == 'one-third') {
		$column_push = 'column-push-one-third';			
	} else if ( $column_push == 'one-half' ) { 
		$column_push = 'column-push-half';
	} else if ( $column_push == 'two-thirds' ) { 
		$column_push = 'column-push-two-thirds';			
	} else if ( $column_push == 'three-quarters' ) {
		$column_push = 'column-push-three-quarters';
	} else {
		$column_push = '';
	}
	$s .= '<section class="niche-hero '.$column_push.' '.$unique_shortcode_id.'-main nh-'.$display.'">';
		$s .= '<ul class="niche-posts">';
		$recent_posts = wp_get_recent_posts(array( 'numberposts' => $number_of_posts, 'order' => $order_by, 'post_type' => $post_type, 'offset' => $post_offset, 'post_status' => $post_status));
		foreach($recent_posts as $key => $post){
		reset($recent_posts);
			/* SIZE INDIVIDUAL POST BASED ON COLUMN SELECTION */
			if ($columns == '4') {
				$columns = '25%;';
			} else if ( $columns == '3' ) { 
				$columns = '33.3%';
			} else if ( $columns == '2' ) {
				$columns = '50%';
			} else if ( $columns == '1' ) {
				$columns = '100%';					
			}
			/* VIDEO VIEWS */
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
			/* COMMENTS */
			if ($comments_enabled == 1) {
				$nh_comments = '<span class="nh-comment-number"><i class="nh-comment-icon"></i>'.get_comments_number($post['ID']).'</span>';
			}
			/* COMBINE POST META DATA VALUES */
			$nh_meta = '<div class="nh-meta">'.$nh_post_views . $nh_comments.'</div>';		
			/* TITLE */
			$nh_title = '<div class="nh-title"><h4>'.$post['post_title'].'</h4></div>';
			/* DATE */
			if($show_date && ($display == 1 && $key != 0 && $key != 1) || $display == 3 || ($display == 2 && $key != 0 && $key != 1 && $key != 2)){
				$nh_date = '<div class="nh-date">'.get_the_date( 'F j, Y', $post['ID']).'</div>';
			} else if ($show_date_in_lead == 1){
				$nh_date = '<div class="nh-date">'.get_the_date( 'F j, Y', $post['ID']).'</div>';			
			}
			/* FETCH POST THUMNAIL OR PLACEHOLDER IMAGES */
			if(has_post_thumbnail($post['ID'])){
				$nh_post_thumbnail = get_the_post_thumbnail_url($post['ID'],'full');
			} else if (($display == 1 && ($key === 0 || $key === 1)) || ($display == 2 && ($key === 0 || $key === 1 || $key === 2))) { 
				$nh_post_thumbnail = '<div class="nh-bg-placeholder" style="height:'.$image_height_in_lead.';background:url('.plugin_dir_url( __FILE__ ).'assets/images/260x150.png)"></div>'; 
			} else {
				$nh_post_thumbnail = '<div class="nh-bg-placeholder" style="height:'.$image_height.';background:url('.plugin_dir_url( __FILE__ ).'assets/images/260x150.png)"></div>'; 			
			}
			/* AUTHOR */
			$author_id = get_post_field( 'post_author', $post['ID']);
			if (is_plugin_active('wp-user-avatar/wp-user-avatar.php')) {
				$nh_avatar = get_wp_user_avatar(get_the_author_meta('ID'), 44, 'left').'<span class="author-tooltip">'.get_the_author_meta( 'display_name', $author_id ).'</span></div>';
			} else {
				$nh_avatar = '<img src="'.get_avatar_url($post['ID'], ['size' => '44']).'"/><span class="author-tooltip">'.get_the_author_meta( 'display_name', $author_id ).'</span></div>';
			}
			/* ADD ALL AUTHORS TOGETHER */
			if (($show_author == 1) && ($display == 1 && $key != 0 && $key != 1) || $display == 3 || ($display == 2 && $key != 0 && $key != 1 && $key != 2)) {
				$nh_detailed  = '<a href="'.get_permalink($post['ID']).'" class="nh-details">
				<div class="nh-avatar-box">'.$nh_avatar.'<div class="nh-content">'. $nh_date . $nh_title . $nh_meta .'</div></a>';
			} else {
				$nh_detailed  = '<a href="'.get_permalink($post['ID']).'" class="nh-details">' . $nh_date . $nh_title . $nh_meta .'</a>';
			}
			/* DISPLAY SECTION #1: TWO HERO BOXES */
			if ($display == '1') {
				if($key === key($recent_posts)) { 
					$s .= '<li class="'.$unique_shortcode_id.' first-niche-post"><span style="background:'.$overlay_color.'" class="niche-overlay"></span>'; 
				}else if($key===1){ 
					$s .= '<li class="'.$unique_shortcode_id.' second-niche-post"><span style="background: '.$second_overlay_color.'" class="niche-overlay"></span>'; 
				}else{
					$s .= '<li class="'.$unique_shortcode_id.' niche-post" style="min-height:'.$min_height.';width:'.$columns.'">'; 
				}
				/* DISPLAY POST THUMBNAIL OR PLACEHOLDER IMAGE */
				if(has_post_thumbnail($post['ID'])){
					if (($key === key($recent_posts) || $key === 1) && $box_shadow_in_lead != '' ){
						$s .= '<a class="nh-post-thumbnail" style="box-shadow: '.$box_shadow_in_lead.' !important;background: url('.$nh_post_thumbnail.');" href="'.get_permalink($post['ID']).'">'; 				
					} else {
						$s .= '<div class="pd-5"><a class="nh-post-thumbnail" style="background: url('.$nh_post_thumbnail.');" href="'.get_permalink($post['ID']).'">'; 
						$s .= '</div>';
					}
				}else{ 
					$s .= '<div class="pd-5"><a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail; 
					$s .= '</div>';
				}
				$s .= '</a>';			
				$s .= $nh_detailed;
				$s .= '</li>';		
			/* DISPLAY SECTION #2: THREE HERO BOXES */
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
						$s .= '<a class="nh-post-thumbnail" style="box-shadow: '.$box_shadow_in_lead.';background: url('.$nh_post_thumbnail.');" href="'.get_permalink($post['ID']).'">'; 				
					} else {
						$s .= '<a class="nh-post-thumbnail" style="background: url('.$nh_post_thumbnail.');" href="'.get_permalink($post['ID']).'">'; 
					}
				}else{ 
					$s .= '<a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail; 
				}
				$s .= '</a>';
				$s .= $nh_detailed;
				$s .= '</li>';	
			/* DISPLAY SECTION #3: HERO LIST */
			} else if ($display == '3') {
					$s .= '<li class="niche-post" style="min-height: '.$min_height.'; width:'.$columns.';"><div class="pd-5">'; 
						if($columns=='50%'){
							if (has_post_thumbnail($post['ID'])){
								$s .= '<a class="nh-post-thumbnail" style="padding-top: '.$image_height.'; height:'.$image_height.'; background: url('.$nh_post_thumbnail.');" href="'.get_permalink($post['ID']).'"></a>';
							}else{
								$s .= '<a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail.'</a>';
							}						
							$s .= $nh_detailed;
						}else{
							if (has_post_thumbnail($post['ID'])){
								$s .= '<a class="nh-post-thumbnail" style="padding-top: '.$image_height.'; height:'.$image_height.'; background: url('.$nh_post_thumbnail.');" href="'.get_permalink($post['ID']).'"></a>'; 
							} else { 
								$s .= '<a class="nh-default-thumbnail" href="'.get_permalink($post['ID']).'">' . $nh_post_thumbnail.'</a>'; 
							}
							$s .= $nh_detailed;
						}
					$s .= '</div></li>';						
			}
			}
		$s .= '</ul>';
		$s .= '</section>';
		return $s;
	// END TYPE: STANDARD
	// START TYPE: BAR
	} else if ($type == 'bar') {
		extract(shortcode_atts(array(
			'spacing' => '0',
			'heading' => '',
			'number_of_posts' => '3',
			'show_title' => 'true',
			'show_date' => 'false',
			'show_read_more' => 'false',
			'thumb_size' => 'thumbnail',
		), $atts ));	
		ob_start();
		$recent_posts = new WP_Query( array(
		'posts_per_page' => $number_of_posts
		));
		$s .= '<section class="niche-hero nh-type-bar column-push-one-third" style="padding: './*$spacing*/ " ".' !important">';
			if ($heading != '') {
				$s .= '<div class="niche_hero-recent niche_hero-recent-shortcode "><h3>'.$heading.'</h3>'; 
			}
			if ( $recent_posts->have_posts() ) :
				$s .= '<ul class="gs-recent-posts-thumbnails">';
				while($recent_posts->have_posts()): $recent_posts->the_post(); 
				// VIDEO VIEWS
				if (pvc_get_post_views( get_the_ID()) <= 999) {
					$nh_post_views = pvc_get_post_views( get_the_ID()); 
				} else if( pvc_get_post_views( get_the_ID()) >= 1000 && pvc_get_post_views( get_the_ID()) <= 999999 ) {
					$nh_post_views = floor(pvc_get_post_views( get_the_ID())/1000) . 'K'; 
				} else if( pvc_get_post_views( get_the_ID()) >= 1000000 && pvc_get_post_views( get_the_ID()) <= 1099999 ) {
					$nh_post_views = floor(pvc_get_post_views( get_the_ID())/1000000) . 'M'; 		
				} else if( pvc_get_post_views( get_the_ID()) >= 1100000 ) {
					$nh_post_views = number_format(pvc_get_post_views( get_the_ID())/1000000, 1) . 'M'; 				
				}		
				$s .= '<li>';
				  $s .= '<a class="thumbnail-overlay" href="'. the_permalink() .'"></a>';
					if (has_post_thumbnail()):
						$s .= get_the_post_thumbnail($post['ID'],'full');
					endif;
					$s .= '<span class="video-views">'.$nh_post_views.'</span>';
					$s .= '<span class="comment-number">'.get_comments_number(get_the_ID()).'</span>';
					if ( $show_title == true ) :
						$s .= '<h4>'.get_the_title().'</h4>';
					endif;
					if ( $show_date == true ) : 
						$s .= '<span>'.get_the_date().'</span>';
					endif;
					if ( $show_read_more == true ):
						$s .= '<span>Read more</span>';
					endif;
				$s .= '</li>';
				endwhile;
				$s .= '</ul>';
			else :
				$s .= 'No posts found.';
			endif; 
		$s .= '</section>';
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();
		return $s;
	}
	// END TYPE: BAR
}

/* NICHE HERO ROW */
function niche_hero_row( $atts = array(), $content = null ) {
		extract(shortcode_atts(array(
			'spacing' => '0 35px'
		), $atts ));
    $content = do_shortcode( $content );
 
    // always return
    return '<div class="nh-row" style="padding: '.$spacing.'">'.$content.'</div>';
}

/* NICHE HERO SHORTCODE REGISTRATION */
add_shortcode('nichehero','niche_hero_shortcode');
add_shortcode( 'nh_row', 'niche_hero_row' );

/* Registrate Niche Hero Stylesheet */
function niche_hero_add_stylesheet() {
    wp_enqueue_style( 'niche-hero-css', plugins_url( '/assets/css/style.css', __FILE__ ) );
	if (get_theme_mod('nh_enable_font_awesome') == 'enable') {
		wp_enqueue_style( 'niche-hero-font-awesome-css', plugins_url( '/assets/css/all.min.css', __FILE__ ) );
	}
	// REGISTER GOOGLE FONTS
	if (get_theme_mod('nh_select_google_font') == 'Roboto') {
		wp_enqueue_style( 'google-font-import-roboto', 'https://fonts.googleapis.com/css2?family=Roboto&display=swap' );	
	} else if (get_theme_mod('nh_select_google_font') == 'Open Sans') {
		wp_enqueue_style( 'google-font-import-open-sans', 'https://fonts.googleapis.com/css2?family=Open+Sans&display=swap' );		
	} else if (get_theme_mod('nh_select_google_font') == 'Lato') {
		wp_enqueue_style( 'google-font-import-lato', 'https://fonts.googleapis.com/css2?family=Lato&display=swap' );
	}
}

// APPLY CUSTOM STYLES
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

/* PRIORITIZE LOADING OF STYLESHEET AT LOAD BY UTILIZING 1 */
add_action('wp_head', 'niche_hero_add_stylesheet', 1);

/* REGISTER WORDPRESS CUSTOMIZER */
function niche_hero_plugin_customizer( $wp_customize ) {
	/* ADD NICHE HERO SECTION */
	$wp_customize->add_section(
		'niche_hero_section',
		array(
			'title'      => __( 'Niche Hero', 'globestar' ),
			'priority'   => 9999,
			'capability' => 'edit_theme_options',
		)
	); 
	// ENABLE FONT AWESOME SETTING
	$wp_customize->add_setting(
		'nh_enable_font_awesome',
		array(
			'default' => 'disable',
		)
	);
	// FONT AWESOME CONTROL
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
	// SELECT GOOGLE FONT SETTING
	$wp_customize->add_setting(
		'nh_select_google_font',
		array(
			'default' => 'Roboto',
		)
	);
	// GOOGLE FONT CONTROL
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

/* ## INCLUDE WIDGETS ## */

/* RECENT POSTS WITH FEATURED IMAGE */
include( plugin_dir_path( __FILE__ ) . 'components/widgets/recent_posts_with_featured_image.php');

