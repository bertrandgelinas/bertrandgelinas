<?php
/**
 * Instagram Widget
*/
class uwl_instagram extends WP_Widget {

	public function __construct() {

        parent::__construct(
            'uwl_instagram',
            $name = __( 'UWL - Instagram', 'kho' ),
            array(
                'classname'		=> 'uwl_widget_wrap uwl_instagram_widget',
				'description'	=> __( 'Displays Instagram photos.', 'kho' )
            )
        );

        if ( is_active_widget(false, false, $this->id_base) ) {
			if ( '1' !== uwl_option( 'minify_css', '1' ) ) {
				add_action( 'wp_enqueue_scripts', array(&$this,'uwl_instagram_script'), 15);
			}
		}

    }

	public function uwl_instagram_script() {
		wp_enqueue_style( 'uwl-instagram', uwl_plugin_url( 'assets/css/styles/widgets/instagram.css' ) );
	}
	
	// display the widget in the theme
	public function widget($args, $instance) {
		extract($args);
		$title 			= apply_filters('widget_title', $instance['title']);
		$class_wrap 	= isset( $instance['class_wrap'] ) ? $instance['class_wrap'] : '';
		$columns 		= isset( $instance['columns'] ) ? $instance['columns'] : '';
		$margin 		= isset( $instance['margin'] ) ? $instance['margin'] : '';
		$username 		= isset( $instance['username'] ) ? $instance['username'] : 'adidas';
		$limit 			= isset( $instance['number'] ) ? $instance['number'] : 9;
		$target 		= isset( $instance['target'] ) ? $instance['target'] : '';
		$follow 		= isset( $instance['follow'] ) ? $instance['follow'] : '';

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
			if ( $username != '' ) {
				$media_array = uwl_scrape_instagram( $username, $limit );
				if ( is_wp_error( $media_array ) ) {
					echo $media_array->get_error_message();
				} else { ?>
					<ul class="uwl-instagram-pics <?php echo esc_attr( $columns ); ?> <?php echo esc_attr( $margin ); ?>">
						<?php foreach ( $media_array as $item ) {
							echo '<li><a href="'. esc_url( $item['link'] ) .'" target="_'. esc_attr( $target ) .'"><img src="'. esc_url( $item['thumbnail'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" /></a></li>';
						} ?>
					</ul>
				<?php
				}
			}

			if ( $follow != '' ) { ?>
				<p class="uwl-instagram-link">
					<a href="//instagram.com/<?php echo esc_attr( trim( $username ) ); ?>" rel="me" target="_<?php echo esc_attr( $target ); ?>"><?php echo esc_attr( $follow ); ?></a>
				</p>
			<?php
			}
		echo $after_widget;
	}
	
	// update the widget when new options have been entered
	public function update( $new_instance, $old_instance ) {
		$instance 					= $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['class_wrap'] 	= strip_tags($new_instance['class_wrap']);
		$instance['columns'] 		= strip_tags($new_instance['columns']);
		$instance['margin'] 		= $new_instance['margin'];
		$instance['username'] 		= $new_instance['username'];
		$instance['number'] 		= $new_instance['number'];
		$instance['target'] 		= $new_instance['target'];
		$instance['follow'] 		= $new_instance['follow'];
		return $instance;
	}
	
	// print the widget option form on the widget management screen
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> __('Instagram','kho'),
			'class_wrap' 	=> '',
			'columns' 		=> '',
			'margin' 		=> __('Yes','kho'),
			'username' 		=> __('adidas','kho'),
			'number' 		=> 9,
			'target' 		=> 'blank',
			'follow' 		=> __('Follow','kho'),
		)); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'kho'); ?></label>			
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('class_wrap'); ?>"><?php _e('Class Wrap (optional):', 'kho'); ?></label>			
			<input class="widefat" id="<?php echo $this->get_field_id('class_wrap'); ?>" name="<?php echo $this->get_field_name('class_wrap'); ?>" type="text" value="<?php echo $instance['class_wrap']; ?>" />
		</p>

		<p class="uwl-left">
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Images Style:', 'kho'); ?></label>
			<select class='uwl-widget-select widefat' name="<?php echo $this->get_field_name('columns'); ?>" id="<?php echo $this->get_field_id('columns'); ?>">
				<option value="style-one" <?php if($instance['columns'] == 'style-one') { ?>selected="selected"<?php } ?>><?php _e( 'Style 1', 'kho' ); ?></option>
				<option value="style-two" <?php if($instance['columns'] == 'style-two') { ?>selected="selected"<?php } ?>><?php _e( 'Style 2', 'kho' ); ?></option>
				<option value="style-three" <?php if($instance['columns'] == 'style-three') { ?>selected="selected"<?php } ?>><?php _e( 'Style 3', 'kho' ); ?></option>
				<option value="two-columns" <?php if($instance['columns'] == 'two-columns') { ?>selected="selected"<?php } ?>><?php _e( '2 Columns', 'kho' ); ?></option>
				<option value="three-columns" <?php if($instance['columns'] == 'three-columns') { ?>selected="selected"<?php } ?>><?php _e( '3 Columns', 'kho' ); ?></option>
				<option value="four-columns" <?php if($instance['columns'] == 'four-columns') { ?>selected="selected"<?php } ?>><?php _e( '4 Columns', 'kho' ); ?></option>
			</select>
		</p>

		<p class="uwl-right">
			<label for="<?php echo $this->get_field_id('margin'); ?>"><?php _e('Margin:', 'kho'); ?></label>
			<select class='uwl-widget-select widefat' name="<?php echo $this->get_field_name('margin'); ?>" id="<?php echo $this->get_field_id('margin'); ?>">
				<option value="margin" <?php if($instance['margin'] == 'margin') { ?>selected="selected"<?php } ?>><?php _e( 'Margin', 'kho' ); ?></option>
				<option value="no-margin" <?php if($instance['margin'] == 'no-margin') { ?>selected="selected"<?php } ?>><?php _e( 'No Margin', 'kho' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e( 'Username:', 'kho' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $instance['username']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number Of Photos:', 'kho' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $instance['number']; ?>" />
			<small><?php _e('The maximum is 24 images.', 'kho'); ?></small>
		</p>

		<p class="uwl-left">
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Links Target:', 'kho' ); ?></label>
			<select class='uwl-widget-select widefat' name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>">
				<option value="blank" <?php if($instance['target'] == 'blank') { ?>selected="selected"<?php } ?>><?php _e( 'Blank', 'kho' ); ?></option>
				<option value="self" <?php if($instance['target'] == 'self') { ?>selected="selected"<?php } ?>><?php _e( 'Self', 'kho'); ?></option>
			</select>
		</p>

		<p class="uwl-right">
			<label for="<?php echo $this->get_field_id('follow'); ?>"><?php _e( 'Follow Text:', 'kho' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('follow'); ?>" name="<?php echo $this->get_field_name('follow'); ?>" type="text" value="<?php echo $instance['follow']; ?>" />
		</p>

		<p style="background: #fcfcfc; padding: 10px; border: 1px solid #e3e3e3; text-align: center; text-transform: uppercase;"><?php _e( 'More Widgets?', 'kho' ); ?> <a href="http://codecanyon.net/item/ultimate-widgets-wordpress-plugin/12007937?ref=Khothemes" target="_blank"><?php _e( 'Buy the PRO version', 'kho' ); ?></a></p>

	<?php
	}
}