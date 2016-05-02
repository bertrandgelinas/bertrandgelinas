<?php
/**
 * MailChimp Widget
*/
class uwl_mailchimp extends WP_Widget {

	public function __construct() {

        parent::__construct(
            'uwl_mailchimp',
            $name = __( 'UWL - MailChimp', 'kho' ),
            array(
                'classname'		=> 'uwl_widget_wrap uwl_newsletter_widget',
				'description'	=> __( 'Displays Mailchimp Subscription Form.', 'kho' )
            )
        );

        if ( is_active_widget(false, false, $this->id_base) ) {
			if ( '1' !== uwl_option( 'minify_css', '1' ) ) {
				add_action( 'wp_enqueue_scripts', array(&$this,'uwl_mailchimp_script'), 15);
			}
		}

    }

	public function uwl_mailchimp_script() {
		wp_enqueue_style( 'uwl-mailchimp', uwl_plugin_url( 'assets/css/styles/widgets/mailchimp.css' ) );
	}
	
	// display the widget in the theme
	public function widget($args, $instance) {
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title']);
		$class_wrap 		= isset( $instance['class_wrap'] ) ? $instance['class_wrap'] : '';
		$mailchimpaction 	= $instance['mailchimpaction'];
		$mailchimpbtn 		= $instance['mailchimpbtn'];
		$placeholder 		= $instance['placeholder'];
		$center_text 		= $instance['center_text'];
		$subscribe_text 	= $instance['subscribe_text'];

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

		if ( $center_text == '1' ) {
			$center_text = 'text-align: center';
		} else if ( is_rtl() ) {
			$center_text = 'text-align: right';
		} else {
			$center_text = 'text-align: left';
		}

		echo $before_widget;
			if($title) { ?>
				<h3 class="uwl-title">
					<span><?php echo esc_attr( $title ); ?></span>
				</h3>
			<?php } ?>
			<p class="uwl-mail-text" style="<?php echo esc_attr( $center_text ); ?>"><?php echo esc_attr( $subscribe_text ); ?></p>
			<form action="<?php echo esc_url( $mailchimpaction ); ?>" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<div class="uwl-form-wrap">
					<input type="email" value="" name="EMAIL" class="required email" placeholder="<?php echo esc_attr( $placeholder ) ?>">
				</div>
				<input type="submit" value="<?php echo esc_attr( $mailchimpbtn ); ?>" name="subscribe">
			</form>
		<?php
		echo $after_widget;
	}
	
	// update the widget when new options have been entered
	public function update( $new_instance, $old_instance ) {
		$instance 						= $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['class_wrap'] 		= strip_tags($new_instance['class_wrap']);
		$instance['mailchimpaction'] 	= $new_instance['mailchimpaction'];
		$instance['mailchimpbtn'] 		= $new_instance['mailchimpbtn'];
		$instance['placeholder'] 		= $new_instance['placeholder'];
		$instance['center_text'] 		= (int)$new_instance['center_text'];
		$instance['subscribe_text'] 	= $new_instance['subscribe_text'];
		return $instance;
	}
	
	// print the widget option form on the widget management screen
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' 			=> __('Newsletter','kho'),
			'class_wrap' 		=> '',
			'center_text'		=> __('Yes','kho'),
			'subscribe_text' 	=> __('Get all latest content delivered to your email a few times a month. Updates and news about all categories will send to you.','kho'),
			'mailchimpaction' 	=> '',
			'placeholder' 		=> __('Your Email','kho'),
			'mailchimpbtn' 		=> __('Sign Up','kho')
		)); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'kho'); ?></label>			
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('class_wrap'); ?>"><?php _e('Class Wrap (optional):', 'kho'); ?></label>			
			<input class="widefat" id="<?php echo $this->get_field_id('class_wrap'); ?>" name="<?php echo $this->get_field_name('class_wrap'); ?>" type="text" value="<?php echo $instance['class_wrap']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('center_text'); ?>"><?php _e( 'Center Text:', 'kho' ); ?></label>
			<select class='uwl-widget-select widefat' name="<?php echo $this->get_field_name('center_text'); ?>" id="<?php echo $this->get_field_id('center_text'); ?>">
				<option value="1" <?php if($instance['center_text'] == '1') { ?>selected="selected"<?php } ?>><?php _e( 'Yes', 'kho' ); ?></option>
				<option value="0" <?php if($instance['center_text'] == '0') { ?>selected="selected"<?php } ?>><?php _e( 'No', 'kho'); ?></option>
			</select>
		</p>
			
		<p>
			<label for="<?php echo $this->get_field_id( 'subscribe_text' ); ?>"><?php _e('Text:', 'kho'); ?></label>
			<textarea style="height:100px;" class="widefat" id="<?php echo $this->get_field_id( 'subscribe_text' ); ?>" name="<?php echo $this->get_field_name( 'subscribe_text' ); ?>"><?php echo stripslashes(htmlspecialchars(( $instance['subscribe_text'] ), ENT_QUOTES)); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('mailchimpaction'); ?>"><?php _e('MailChimp Form Action:', 'kho'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('mailchimpaction'); ?>" name="<?php echo $this->get_field_name('mailchimpaction'); ?>" type="text" value="<?php echo $instance['mailchimpaction']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('placeholder'); ?>"><?php _e('Placeholder:', 'kho'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('placeholder'); ?>" name="<?php echo $this->get_field_name('placeholder'); ?>" type="text" value="<?php echo $instance['placeholder']; ?>" />
		</p>
			
		<p>
			<label for="<?php echo $this->get_field_id('mailchimpbtn'); ?>"><?php _e('Button title:', 'kho'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('mailchimpbtn'); ?>" name="<?php echo $this->get_field_name('mailchimpbtn'); ?>" type="text" value="<?php echo $instance['mailchimpbtn']; ?>" />
		</p>

		<p style="background: #fcfcfc; padding: 10px; border: 1px solid #e3e3e3; text-align: center; text-transform: uppercase;"><?php _e( 'More Widgets?', 'kho' ); ?> <a href="http://codecanyon.net/item/ultimate-widgets-wordpress-plugin/12007937?ref=Khothemes" target="_blank"><?php _e( 'Buy the PRO version', 'kho' ); ?></a></p>

	<?php
	}
}