<?php
/**
 * Plugin Name: Niche Hero
 * Plugin URI: https://github.com/dallasrowling/niche-hero
 * Description: Niche Hero provides the blog hero section.
 * Version: 1.0.1
 * Author: Dallas Rowling
 * Author URI: https://github.com/dallasrowling
 */
 
/* NICHE HERO CONTENT */
function niche_hero_shortcode( $atts = array() ) {
	extract(shortcode_atts(array(
		'type' => 'standard',
	), $atts ));
	if($type == 'standard'){
		extract(shortcode_atts(array(
			'number_of_posts' => '6',
			'spacing' => '0px 35px',
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
	/* Run custom css per Niche Hero section (only runs once) */	
	while ($run_loop_once == 0 && $key == 0) {
		$niche_hero_section_styling .= '<style type="text/css">';
			if ($spacing != '0px') {
			/* SPACING */
			$niche_hero_section_styling .= '.'.$unique_shortcode_id.'-main { padding: ' . $spacing .' }';
			}
			if ($meta_bg_in_lead != ''){
			/* META & DATE BG COLOR IN LEAD */ 
			$niche_hero_section_styling .= '.first-niche-post.'.$unique_shortcode_id.' .nh-date, .first-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';
			$niche_hero_section_styling .= '.second-niche-post.'.$unique_shortcode_id.' .nh-date, .second-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';
			$niche_hero_section_styling .= '.third-niche-post.'.$unique_shortcode_id.' .nh-date, .third-niche-post.'.$unique_shortcode_id. ' .nh-meta { background: '.$meta_bg_in_lead.' !important;}';				
			} 
			if ($text_shadow_in_lead != ''){
			/* TEXT SHADOW IN LEAD */ 
			$niche_hero_section_styling .= '.first-niche-post.'.$unique_shortcode_id.' .nh-date, .first-niche-post.'.$unique_shortcode_id.' .nh-title h4, .first-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';
			$niche_hero_section_styling .= '.second-niche-post.'.$unique_shortcode_id.' .nh-date, .second-niche-post.'.$unique_shortcode_id.' .nh-title h4, .second-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';				
			$niche_hero_section_styling .= '.third-niche-post.'.$unique_shortcode_id.' .nh-date, .third-niche-post.'.$unique_shortcode_id.' .nh-title h4, .third-niche-post.'.$unique_shortcode_id. ' .nh-meta { text-shadow: '.$text_shadow_in_lead.' !important;}';								
			}
			if ($border_radius_in_lead != ''){
			$niche_hero_section_styling .= '.first-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .first-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .first-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
			$niche_hero_section_styling .= '.second-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .second-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .second-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
			$niche_hero_section_styling .= '.third-niche-post.'.$unique_shortcode_id.' span.niche-overlay, .third-niche-post.'.$unique_shortcode_id.' a.nh-post-thumbnail, .third-niche-post.'.$unique_shortcode_id.' a.nh-default-thumbnail div.nh-bg-placeholder { border-radius: '.$border_radius_in_lead.' !important;}';
			}
			if ($border_radius != ''){
			$niche_hero_section_styling .= 'li.niche-post.'.$unique_shortcode_id.' .nh-post-thumbnail, li.niche-post.'.$unique_shortcode_id.' .nh-default-thumbnail { border-radius: '.$border_radius.' !important;}';
			}				
		$niche_hero_section_styling .= '</style>';
		$run_loop_once++;
	}
	echo $niche_hero_section_styling;
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
	//$unique_id++;
	reset($recent_posts);
		/* Size individual post based on column selection */
		if ($columns == '4') {
			$columns = '25%;';
		} else if ( $columns == '3' ) { 
			$columns = '33.3%';
		} else if ( $columns == '2' ) {
			$columns = '50%';
		} else if ( $columns == '1' ) {
			$columns = '100%';					
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
		/* Combine post meta values */
		$nh_meta = '<div class="nh-meta">'.$nh_post_views . $nh_comments.'</div>';		
		/* Title */
		$nh_title = '<div class="nh-title"><h4>'.$post['post_title'].'</h4></div>';
		/* Date */
		if($show_date && ($display == 1 && $key != 0 && $key != 1) || $display == 3 || ($display == 2 && $key != 0 && $key != 1 && $key != 2)){
			$nh_date = '<div class="nh-date">'.get_the_date( 'F j, Y', $post['ID']).'</div>';
		} else if ($show_date_in_lead == 1){
			$nh_date = '<div class="nh-date">'.get_the_date( 'F j, Y', $post['ID']).'</div>';			
		}
		/* Fetch post thumbnail or placeholder image */
		if(has_post_thumbnail($post['ID'])){
			$nh_post_thumbnail = get_the_post_thumbnail_url($post['ID'],'full');
		} else if (($display == 1 && ($key === 0 || $key === 1)) || ($display == 2 && ($key === 0 || $key === 1 || $key === 2))) { 
			$nh_post_thumbnail = '<div class="nh-bg-placeholder" style="height:'.$image_height_in_lead.';background:url('.plugin_dir_url( __FILE__ ).'assets/images/260x150.png)"></div>'; 
		} else {
			$nh_post_thumbnail = '<div class="nh-bg-placeholder" style="height:'.$image_height.';background:url('.plugin_dir_url( __FILE__ ).'assets/images/260x150.png)"></div>'; 			
		}
		/* Author */
		if (is_plugin_active('wp-user-avatar/wp-user-avatar.php')) {
			$nh_avatar = get_wp_user_avatar(get_the_author_meta('ID'), 44, 'left').'</div>';
		} else {
			$nh_avatar = '<img src="'.get_avatar_url($post['ID'], ['size' => '44']).'"/></div>';
		}
		/* Add all values together */
		if (($show_author == 1) && ($display == 1 && $key != 0 && $key != 1) || $display == 3 || ($display == 2 && $key != 0 && $key != 1 && $key != 2)) {
			$nh_detailed  = '<a href="'.get_permalink($post['ID']).'" class="nh-details">
			<div class="nh-avatar-box">'.$nh_avatar.'<div class="nh-content">'. $nh_date . $nh_title . $nh_meta .'</div></a>';
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
			} else if ($display == '4'){
			// LAZY CSS GENERATION FOR DISPLAY #4
			echo '
				<style type="text/css">
				section.nh-4 li span.video-views {
					z-index: 1;
					color: #FFF !important;
					position: absolute;
					top: 0;
					padding: 10px 0 0 20px;
					left: 0;
					font-weight: 500;
					text-shadow: 1px 1px #000;
				}

				section.nh-4 li h4 {
					z-index: 1;
					width: 100%;
					text-align: center;
					position: absolute;
					bottom: 0;
					padding: 0 25px 20px;
					left: 0;
					font-size: 20px !important;
					color: #FFF;
					text-shadow: 1px 1px #000;
				}

				section.nh-4 li span.video-views:before {
					font-family: "Font Awesome 5 Free";
					content: "\f080";
					padding-right: 5px;
				}

				section.nh-4 li span.comment-number {
					position: absolute;
					top: 0;
					right: 0;
					color: #FFF !important;
					z-index: 1;
					padding: 10px 20px 0 0;
					font-weight: 500;
					text-shadow: 1px 1px #000;
				}	

				section.nh-4 li:hover img {
					transform: scale(1.2);
				}

				section.nh-4 { 
					border: 5px solid #fff;
				} 	

				section.nh-4 li .nh-comment-number:before {
					font-family: "Font Awesome 5 Free";
					content: "\f075";
					padding-right: 5px;
					font-weight: 700 !important;
				}
							
				section.nh-4 li a.thumbnail-overlay { 
					position: absolute;
					top: 0;
					left: 0;
					width: 100%;
					height: 200px;
					overflow: hidden;
					background: rgba(0,0,0,0.5);
					box-shadow: 2px 2px 100px #222 inset; z-index: 1;
				} 
				
				section.nh-4 li img { 
					transform-origin: 50% 65%;
					transition: transform 1s, filter 3s ease-in-out; 
				} 
				
				section.nh-4 { 
					margin: 0; 
				} 
				
				section.nh-4 li { 
					margin: 0; 
					position: relative; 
					list-style: none;
					overflow: hidden;
					height: 200px; 
				}
				</style>';
				$s .= '<li>';
				  $s .= '<a class="thumbnail-overlay" href="'. /*the_permalink()*/ "" .'"></a>';
					$s .= '<img src="'.$nh_post_thumbnail.'"/>'; 
					$s .= '<span class="video-views">'.$nh_post_views.'</span>';
					$s .= '<span class="comment-number">'.$nh_comments.'</span>';
					$s .= '<h4>'.$post['post_title'].'</h4>';
					if ( $show_date == true ){
					//	$s .= '<span>'.the_date().'</span>';
					}
					$s .= '<span class="neatly--read-more">Read more</span>';
				$s .= '</li>';
			}
		}
		$s .= '</ul>';
		$s .= '</section>';
		return $s;
	} else if ($type == 'bar') {
		extract(shortcode_atts(array(
			'spacing' => '0 35px',
			'heading' => '',
			'number_of_posts' => '3',
			'show_title' => 'true',
			'show_date' => 'false',
			'show_read_more' => 'false',
			'thumb_size' => 'thumbnail',
		), $atts ));	
		ob_start();
		$neatly_loop = new WP_Query( array(
		'posts_per_page' => $number_of_posts
		));
		echo '<style type="text/css">.niche-hero .gs-recent-posts-thumbnails li { margin: 0; } .nh-type-bar { border: 5px solid #FFF; }</style>';
		echo '<section class="niche-hero nh-type-bar column-push-one-third" style="padding: '.$spacing.'">';
		if ($heading != '') { echo '<div class="neatly-recent neatly-recent-shortcode "><h3>'.$heading.'</h3>'; }
		if ( $neatly_loop->have_posts() ) : ?>
		<ul class="gs-recent-posts-thumbnails">
		<?php while ( $neatly_loop->have_posts() ) : $neatly_loop->the_post(); ?>
		<?php
		if (pvc_get_post_views( get_the_ID()) <= 999) {
			$nh_post_views = pvc_get_post_views( get_the_ID()); 
		} else if( pvc_get_post_views( get_the_ID()) >= 1000 && pvc_get_post_views( get_the_ID()) <= 999999 ) {
			$nh_post_views = floor(pvc_get_post_views( get_the_ID())/1000) . 'K'; 
		} else if( pvc_get_post_views( get_the_ID()) >= 1000000 && pvc_get_post_views( get_the_ID()) <= 1099999 ) {
			$nh_post_views = floor(pvc_get_post_views( get_the_ID())/1000000) . 'M'; 		
		} else if( pvc_get_post_views( get_the_ID()) >= 1100000 ) {
			$nh_post_views = number_format(pvc_get_post_views( get_the_ID())/1000000, 1) . 'M'; 				
		}	
		?>	
		<li>
		  <a class="thumbnail-overlay" href="<?php the_permalink(); ?>"></a>
			<?php if ( has_post_thumbnail() ) : the_post_thumbnail($thumbsize); endif; ?>
			<?php echo '<span class="video-views">'.$nh_post_views .'</span>'; ?>
			<?php echo '<span class="comment-number">'.get_comments_number(get_the_ID()).'</span>'; ?>
			<?php if ( $show_title == true ) : ?><h4><?php echo get_the_title(); ?></h4><?php endif; ?>
			<?php if ( $show_date == true ) : ?><span><?php the_date(); ?></span><?php endif; ?>
			<?php if ( $show_read_more == true ) : ?><span class="neatly--read-more">Read more</span><?php endif; ?>
		</li>
		<?php endwhile; ?>
		</ul>
		<?php else : ?>
		No posts found.
		<?php endif; 
		echo '</div></section>';
		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
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



class neatly_recent_posts_thumbnail extends WP_Widget {
    function __construct() {
        parent::__construct(
          'neatly-recent-posts', // Base ID
          'Recent Posts with Thumbnails', // Name
          array( 'description' => __('Display recent posts with thumbnails'), ) // Args
        );
	}
    public function widget($args, $instance) {
            extract($args);
     
	$title = apply_filters( 'widget_title', $instance['title'] );
	$number = $instance['number'];
	$thumbsize = $instance['thumbsize'];
	$show_title = isset($instance['show_title']) ? $instance['show_title'] : true;
	$show_date = isset($instance['show_date']) ? $instance['show_date'] : true;
	$show_read_more = isset($instance['show_read_more']) ? $instance['show_read_more'] : true;  
	echo $before_widget.$before_title;
	if (!empty($title)){
		echo $title;
	}
	echo $after_title;
	$args = array (
	  'posts_per_page' => $number,
	);
	$neatly_posts = new WP_Query($args);
	if( $neatly_posts->have_posts() ) {
	  echo '<ul class="gs-recent-posts-thumbnails">';
	  while( $neatly_posts->have_posts() ) : $neatly_posts->the_post();

	if (pvc_get_post_views( $instance['ID']) <= 999) {
		$nh_post_views = pvc_get_post_views( $instance['ID']); 
	} else if( pvc_get_post_views( $instance['ID']) >= 1000 && pvc_get_post_views( $instance['ID']) <= 999999 ) {
		$nh_post_views = floor(pvc_get_post_views( $instance['ID'])/1000) . 'K'; 
	} else if( pvc_get_post_views( $instance['ID']) >= 1000000 && pvc_get_post_views( $instance['ID']) <= 1099999 ) {
		$nh_post_views = floor(pvc_get_post_views( $instance['ID'])/1000000) . 'M'; 		
	} else if( pvc_get_post_views( $instance['ID']) >= 1100000 ) {
		$nh_post_views = number_format(pvc_get_post_views( $instance['ID'])/1000000, 1) . 'M'; 				
	}
?>		  
            <li>
              <a class="thumbnail-overlay" href="<?php the_permalink(); ?>"></a>
                <?php if ( has_post_thumbnail() ) : the_post_thumbnail($thumbsize); endif; ?>
				<?php echo '<span class="video-views">'.$nh_post_views .'</span>'; ?>
				<?php echo '<span class="comment-number">'.get_comments_number($instance['ID']).'</span>'; ?>
                <?php if ( $show_title == true ) : ?><h4><?php the_title(); ?></h4><?php endif; ?>
                <?php if ( $show_date == true ) : ?><span><?php the_date(); ?></span><?php endif; ?>
                <?php if ( $show_read_more == true ) : ?><span class="neatly--read-more">Read more</span><?php endif; ?>
            </li>
          <?php endwhile;
        }
        
        // Restore original Post Data
        wp_reset_postdata();
            
            echo $after_widget; // ends the widget
        }
            
  
  /* The widget configuration form
  =============================================*/
  
    public function form( $instance ) {
        $title = strip_tags($instance['title']);
        if (isset( $instance[ 'number' ] ) ) {
          $number = $instance['number'];
        } else { $number = '5'; }
        if (isset( $instance[ 'thumbsize' ] ) ) {
          $thumbsize = $instance['thumbsize'];
        } else { $thumbsize = 'thumbnail'; }
        if (isset( $instance[ 'show_title' ] ) ) {
          $show_title = true;
        } else { $show_title = false; }
        if (isset( $instance[ 'show_date' ] ) ) {
          $show_date = true;
        } else { $show_date = false; }
        if (isset( $instance[ 'show_read_more' ] ) ) {
          $show_read_more = true;
        } else { $show_read_more = false; }

    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    <p><em>Use the following options to customize the display.</em></p>
    
    <p style="border-bottom:4px double #eee;padding: 0 0 10px;">
      <label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of Posts Displayed</label>
      <input id="<?php echo $this->get_field_id( 'number'); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr($number); ?>" type="number" style="width:100%;" /><br>
      <label for="<?php echo $this->get_field_id( 'thumbsize' ); ?>">Thumbnail Size</label>
      <input id="<?php echo $this->get_field_id( 'thumbsize'); ?>" name="<?php echo $this->get_field_name( 'thumbsize' ); ?>" value="<?php echo esc_attr($thumbsize); ?>"  style="width:100%;" /><br><br>
      <label for="<?php echo $this->get_field_id( 'show_title' ); ?>">Show the post titles?
      <input id="<?php echo $this->get_field_id( 'show_title'); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" <?php checked($instance['show_title'], true) ?>  type="checkbox" /></label><br><br>
      <label for="<?php echo $this->get_field_id( 'show_date' ); ?>">Show the post dates?
      <input id="<?php echo $this->get_field_id( 'show_date'); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" <?php checked($instance['show_date'], true) ?>  type="checkbox" /></label><br><br>
      <label for="<?php echo $this->get_field_id( 'show_read_more' ); ?>">Show "read more" text for each post?
      <input id="<?php echo $this->get_field_id( 'show_read_more'); ?>" name="<?php echo $this->get_field_name( 'show_read_more' ); ?>" <?php checked($instance['show_read_more'], true) ?>  type="checkbox" /></label>
    </p>
      
    <?php }
    
    /* Saving updated information
    =============================================*/
    
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = strip_tags($new_instance['number']);
        $instance['thumbsize'] = strip_tags($new_instance['thumbsize']);
        $instance['show_title'] = $new_instance['show_title'] ? 1 : 0;
        $instance['show_date'] = $new_instance['show_date'] ? 1 : 0; 
        $instance['show_read_more'] = $new_instance['show_read_more'] ? 1 : 0; 
          
        return $instance;
    }
        
}

function register_neatly_recent_posts_thumbnail() {
    register_widget( 'neatly_recent_posts_thumbnail' );
}
add_action( 'widgets_init', 'register_neatly_recent_posts_thumbnail' );



