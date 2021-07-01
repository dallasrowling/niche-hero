<?php
/* 
WIDGET: RECENT POSTS WITH A FEATURED IMAGE
ADDED IN: VERSION 1.0.5
*/

class niche_hero_recent_posts_with_featured_image extends WP_Widget {
    function __construct() {
        parent::__construct(
          'niche_hero-recent-posts', // WIDGET ID
          'Recent Posts With Featured Image', // WIDGET NAME
          array( 'description' => __('Display recent posts with a featured image.'), ) // ARGUMENTS
        );
	}
    public function widget($args, $instance) {
        extract($args);
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = $instance['number'];
		$thumbsize = $instance['thumbsize'];
		$show_date = isset($instance['show_date']) ? $instance['show_date'] : true;
		$show_video_views = isset($instance['show_video_views']) ? $instance['show_video_views'] : true;
		$show_comments = isset($instance['show_comments']) ? $instance['show_comments'] : true;
		?>
		<div class="widget widget_niche_hero-recent-posts">
			<div class="widget-content">
			<h2 class="widget-title subheading heading-size-3">
				<?php
				if (!empty($title)){
					 echo esc_html($title);
				}
				?>
			</h2>
		<?php
		$args = array (
		  'posts_per_page' => $number,
		);
		$niche_hero_posts = new WP_Query($args);
		if( $niche_hero_posts->have_posts() ) {
			?> 
			<ul class="niche-hero-widget-recent-posts-with-fi"> 
				<?php
				while( $niche_hero_posts->have_posts() ) : $niche_hero_posts->the_post();
				if ($show_video_views==1 && is_plugin_active('post-views-counter/post-views-counter.php')){
					if (pvc_get_post_views( $instance['ID']) <= 999) {
						$nh_post_views = pvc_get_post_views( $instance['ID']); 
					} else if( pvc_get_post_views( $instance['ID']) >= 1000 && pvc_get_post_views( $instance['ID']) <= 999999 ) {
						$nh_post_views = floor(pvc_get_post_views( $instance['ID'])/1000) . 'K'; 
					} else if( pvc_get_post_views( $instance['ID']) >= 1000000 && pvc_get_post_views( $instance['ID']) <= 1099999 ) {
						$nh_post_views = floor(pvc_get_post_views( $instance['ID'])/1000000) . 'M'; 		
					} else if( pvc_get_post_views( $instance['ID']) >= 1100000 ) {
						$nh_post_views = number_format(pvc_get_post_views( $instance['ID'])/1000000, 1) . 'M'; 				
					} 
				} ?>
				<li>
					<div class="nh-image-holder">
						<a class="thumbnail-overlay" href="<?php echo esc_html(get_the_permalink()); ?>"></a>
						<?php if (has_post_thumbnail() ) : the_post_thumbnail($thumbsize); endif; ?>
						<?php if ($show_video_views == true ): ?><span class="video-views"> <?php echo esc_html($nh_post_views); ?></span><?php endif; ?>
						<?php if ($show_comments == true ): ?><span class="comment-number"> <?php echo esc_html(get_comments_number($instance['ID'])); ?></span> <?php endif; ?>
					</div>
					<div class="nh-meta-data">
						<h4><?php echo esc_html(get_the_title()); ?></h4>
						<?php if ($show_date == true ) : ?><span class="nh-date"><?php echo esc_html(get_the_date()); ?></span><?php endif; ?>
						<a href="<?php echo esc_html(get_the_permalink()); ?>" class="nh-read-more">Read more</a>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
        <?php }
        // RESTORE ORIGINAL POST DATA
        wp_reset_postdata();
		// END WIDGET
		?>
		</div>
	</div> <?php
    }
    public function form( $instance ) {
        $title = strip_tags($instance['title']);
        if (isset( $instance[ 'number' ] ) ) {
          $number = $instance['number'];
        } else { $number = '5'; }
        if (isset( $instance[ 'thumbsize' ] ) ) {
          $thumbsize = $instance['thumbsize'];
        } else { $thumbsize = 'thumbnail'; }
        if (isset( $instance[ 'show_date' ] ) ) {
          $show_date = true;
        } else { $show_date = false; }
        if (isset( $instance[ 'show_video_views' ] ) ) {
          $show_video_views = true;
        } else { $show_video_views = false; }
        if (isset( $instance[ 'show_comments' ] ) ) {
          $show_comments = true;
        } else { $show_comments = false; }
    ?>
    <p><label for="<?php echo esc_html($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	<p><em>Use the following options to customize the display.</em></p>
    <p>
      <label for="<?php echo esc_html($this->get_field_id( 'number' )); ?>">How many posts would you like to display?</label>
      <input id="<?php echo esc_html($this->get_field_id( 'number')); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" value="<?php echo esc_attr($number); ?>" type="number" style="width:100%;" /><br>
      <label for="<?php echo esc_html($this->get_field_id( 'thumbsize')); ?>">Size of the featured image?</label>
      <input id="<?php  echo esc_html($this->get_field_id( 'thumbsize')); ?>" style="min-height: 30px; padding: 0 8px; width: 100%; border-radius: 4px; border: 1px solid #8c8f94;" name="<?php echo esc_html($this->get_field_name( 'thumbsize' )); ?>" value="<?php echo esc_html(esc_attr($thumbsize)); ?>" /><br><br>
      <?php if (is_plugin_active('post-views-counter/post-views-counter.php')); { ?>
		<label for="<?php echo esc_html($this->get_field_id( 'show_video_views')); ?>">Show video views per post
		<input id="<?php echo esc_html($this->get_field_id( 'show_video_views')); ?>" name="<?php echo esc_html($this->get_field_name( 'show_video_views' )); ?>" <?php checked($instance['show_video_views'], true) ?>  type="checkbox" /></label><br><br>
	  <?php } ?>
      <label for="<?php echo esc_html($this->get_field_id( 'show_comments' )); ?>">Show amount of comments per post
      <input id="<?php echo esc_html($this->get_field_id( 'show_comments')); ?>" name="<?php echo esc_html($this->get_field_name( 'show_comments' )); ?>" <?php checked($instance['show_comments'], true) ?>  type="checkbox" /></label><br><br>
	  <label for="<?php echo esc_html($this->get_field_id( 'show_date' )); ?>">Show date per post
      <input id="<?php echo esc_html($this->get_field_id( 'show_date')); ?>" name="<?php echo esc_html($this->get_field_name( 'show_date' )); ?>" <?php checked($instance['show_date'], true) ?>  type="checkbox" /></label><br><br>
    </p>
    <?php }
    // SAVE UPDATED INFORMATION
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance; 
        $instance['number'] = strip_tags($new_instance['number']);
        $instance['thumbsize'] = strip_tags($new_instance['thumbsize']);
        $instance['title'] = $new_instance['title'] ? $new_instance['title'] : $old_instance['title'];
        $instance['show_video_views'] = $new_instance['show_video_views'] ? 1 : 0;
        $instance['show_comments'] = $new_instance['show_comments'] ? 1 : 0;
        $instance['show_date'] = $new_instance['show_date'] ? 1 : 0; 
        return $instance;
    }
}

// REGISTER WIDGET AND INITIATE
function register_niche_hero_recent_posts_with_featured_image() {
    register_widget( 'niche_hero_recent_posts_with_featured_image' );
}
add_action( 'widgets_init', 'register_niche_hero_recent_posts_with_featured_image' );