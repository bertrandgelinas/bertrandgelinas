<?php
/**
 * Video Widget
*/
class uwl_video extends WP_Widget {

	public function __construct() {

        parent::__construct(
            'uwl_video',
            $name = __( 'UWL - Video', 'kho' ),
            array(
                'classname'		=> 'uwl_widget_wrap uwl_video_widget',
				'description'	=> __( 'Add a video in your sidebar.', 'kho' )
            )
        );

        if ( is_active_widget(false, false, $this->id_base) ) {
			if ( '1' !== uwl_option( 'minify_css', '1' ) ) {
				add_action( 'wp_enqueue_scripts', array(&$this,'uwl_video_script'), 15);
			}
		}

    }

	public function uwl_video_script() {
		wp_enqueue_style( 'uwl-video', uwl_plugin_url( 'assets/css/styles/widgets/video.css' ) );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title 				= apply_filters('widget_title', $instance['title'] );
		$class_wrap 		= isset( $instance['class_wrap'] ) ? $instance['class_wrap'] : '';
		$caption 			= $instance['caption'];
		$caption_position 	= $instance['caption_position'];

		// Class wrap
		if ( '' != $class_wrap ) {
      		$class_widget = $class_wrap;
		} else {
      		$class_widget = uwl_option('widgets_style', 'style1');
		}

		// no 'class' attribute
		if( strpos($before_widget, 'class') === false ) {
			$before_widget = str_replace('>', 'class="'. $class_widget . '"', $before_widget);
		}
		// there is 'class' attribute
		else {
			$before_widget = str_replace('class="', 'class="'. $class_widget . ' ', $before_widget);
		}

		echo $before_widget;
			if($title) { ?>
				<h3 class="uwl-title">
					<span><?php echo esc_attr( $title ); ?></span>
				</h3>
			<?php }

			// Caption before
			if( $caption && 'before' == $caption_position ){
				echo '<p class="videocaption before">'.do_shortcode( $caption ).'</p>';
			}

			// Show video
			if ( !empty( $instance['embed_code'] ) ) {
				echo $instance['embed_code'];
			} else { ?>
				<div class="uwl-error"><?php _e( 'You forgot to enter a video URL.', 'kho' ); ?></div>
			<?php }

			// Caption after
			if( $caption && 'after' == $caption_position ){
				echo '<p class="videocaption after">'.do_shortcode( $caption ).'</p>';
			}
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance 						= $old_instance;
		$instance['title'] 				= strip_tags( $new_instance['title'] );
		$instance['class_wrap'] 		= strip_tags( $new_instance['class_wrap'] );
		$instance['embed_code'] 		= $new_instance['embed_code'];
		$instance['caption'] 			= $new_instance['caption'];
		$instance['caption_position'] 	= strip_tags( $new_instance['caption_position'] );
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args((array) $instance, array(
			'title' 			=> __('Video','kho'),
			'class_wrap' 		=> '',
			'embed_code' 		=> '',
			'caption' 			=> '',
			'caption_position' 	=> __('Before','kho'),
		)); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'kho'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('class_wrap'); ?>"><?php _e('Class Wrap (optional):', 'kho'); ?></label>			
			<input class="widefat" id="<?php echo $this->get_field_id('class_wrap'); ?>" name="<?php echo $this->get_field_name('class_wrap'); ?>" type="text" value="<?php echo $instance['class_wrap']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'embed_code' ); ?>"><?php _e( 'Embed Code' , 'kho') ?></label>
			<textarea style="height: 80px;" id="<?php echo $this->get_field_id( 'embed_code' ); ?>" name="<?php echo $this->get_field_name( 'embed_code' ); ?>" class="widefat" ><?php if( !empty( $instance['embed_code'] ) ) echo $instance['embed_code']; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'caption' ); ?>"><?php _e( 'Caption:' , 'kho') ?></label>
			<textarea style="height: 40px;" id="<?php echo $this->get_field_id( 'caption' ); ?>" name="<?php echo $this->get_field_name( 'caption' ); ?>" class="widefat" ><?php if( !empty( $instance['caption'] ) ) echo $instance['caption']; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'caption_position' ); ?>"><?php _e('Caption Position:', 'kho'); ?></label>
			<select name="<?php echo $this->get_field_name( 'caption_position' ); ?>" id="<?php echo $this->get_field_id( 'caption_position' ); ?>" class="widefat">
				<option value="before" <?php if($instance['caption_position'] == 'before') { ?>selected="selected"<?php } ?>><?php _e('Before', 'kho'); ?></option>
				<option value="after" <?php if($instance['caption_position'] == 'after') { ?>selected="selected"<?php } ?>><?php _e('After', 'kho'); ?></option>
			</select>
		</p>

<?php

	}
}