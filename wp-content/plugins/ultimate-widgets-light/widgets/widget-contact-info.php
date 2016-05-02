<?php
/**
 * Contact Info Widget
*/
class uwl_contact_info extends WP_Widget {

	public function __construct() {

        parent::__construct(
            'uwl_contact_info',
            $name = __( 'UWL - Contact Info', 'kho' ),
            array(
                'classname'		=> 'uwl_widget_wrap uwl_contact_info_widget',
				'description'	=> __( 'Adds support for Contact Info.', 'kho' )
            )
        );

        if ( is_active_widget(false, false, $this->id_base) ) {
			if ( '1' !== uwl_option( 'minify_css', '1' ) ) {
				add_action( 'wp_enqueue_scripts', array(&$this,'uwl_contact_info_script'), 15);
			}
		}

    }

	public function uwl_contact_info_script() {
		wp_enqueue_style( 'uwl-contact-info', uwl_plugin_url( 'assets/css/styles/widgets/contact-info.css' ) );
	}

	public function widget($args, $instance) {
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title']);
		$class_wrap = isset( $instance['class_wrap'] ) ? $instance['class_wrap'] : '';
		$info_style = isset( $instance['info_style'] ) ? $instance['info_style'] : '';
		$text 		= isset( $instance['text'] ) ? $instance['text'] : '';
		$address 	= isset( $instance['address'] ) ? $instance['address'] : '';
		$phone 		= isset( $instance['phone'] ) ? $instance['phone'] : '';
		$mobile 	= isset( $instance['mobile'] ) ? $instance['mobile'] : '';
		$fax 		= isset( $instance['fax'] ) ? $instance['fax'] : '';
		$email 		= isset( $instance['email'] ) ? $instance['email'] : '';
		$emailtxt 	= isset( $instance['emailtxt'] ) ? $instance['emailtxt'] : '';
		$web 		= isset( $instance['web'] ) ? $instance['web'] : '';
		$webtxt 	= isset( $instance['webtxt'] ) ? $instance['webtxt'] : '';
		$skype 		= isset( $instance['skype'] ) ? $instance['skype'] : '';
		$skypetxt 	= isset( $instance['skypetxt'] ) ? $instance['skypetxt'] : '';

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
			<?php } ?>
			<ul class="contact-info-container uwl-ul <?php echo esc_attr( $info_style ); ?>">
				<?php if($text) { ?>
					<li class="text"><?php echo esc_attr( $text ); ?></li>
				<?php } ?>

				<?php if($address) { ?>
					<li class="address">
						<i class="icon_pin"></i>
						<div class="uwl-info-wrap">
							<span class="uwl-contact-title"><?php _e('Address:', 'kho'); ?></span>
							<span class="uwl-contact-text"><?php echo esc_attr( $address ); ?></span>
						</div>
					</li>
				<?php } ?>

				<?php if($phone) { ?>
					<li class="phone">
						<i class="icon_phone"></i>
						<div class="uwl-info-wrap">
							<span class="uwl-contact-title"><?php _e('Phone:', 'kho'); ?></span>
							<span class="uwl-contact-text"><?php echo esc_attr( $phone ); ?></span>
						</div>
					</li>
				<?php } ?>

				<?php if($mobile) { ?>
					<li class="mobile">
						<i class="icon_mobile"></i>
						<div class="uwl-info-wrap">
							<span class="uwl-contact-title"><?php _e('Mobile:', 'kho'); ?></span>
							<span class="uwl-contact-text"><?php echo esc_attr( $mobile ); ?></span>
						</div>
					</li>
				<?php } ?>

				<?php if($fax) { ?>
					<li class="fax">
						<i class="icon_printer-alt"></i>
						<div class="uwl-info-wrap">
							<span class="uwl-contact-title"><?php _e('Fax:', 'kho'); ?></span>
							<span class="uwl-contact-text"><?php echo esc_attr( $fax ); ?></span>
						</div>
					</li>
				<?php } ?>

				<?php if($email) { ?>
					<li class="email">
						<i class="fa fa-envelope-o"></i>
						<div class="uwl-info-wrap">
							<span class="uwl-contact-title"><?php _e('Email:', 'kho'); ?></span>
							<span class="uwl-contact-text">
								<a href="mailto:<?php echo esc_attr( $email ); ?>">
									<?php if($emailtxt) { echo esc_attr( $emailtxt ); } else { echo esc_attr( $email ); } ?>
								</a>
							</span>
						</div>
					</li>
				<?php } ?>

				<?php if($web) { ?>
					<li class="web">
						<i class="fa fa-globe"></i>
						<div class="uwl-info-wrap">
							<span class="uwl-contact-title"><?php _e('Website:', 'kho'); ?></span>
							<span class="uwl-contact-text">
								<a href="<?php echo esc_url( $web ); ?>">
									<?php if($webtxt) { echo esc_attr( $webtxt ); } else { echo esc_attr( $web ); } ?>
								</a>
							</span>
						</div>
					</li>
				<?php } ?>

				<?php if($skype) { ?>
					<li class="skype">
						<a href="skype:<?php echo esc_attr( $skype ); ?>?call" target="_self" class="uwl-skype-button">
							<span class="social_skype"></span>
							<?php if($skypetxt) { echo esc_attr( $skypetxt ); } else { _e('Skype', 'kho'); } ?>
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php
		echo $after_widget;
	}

	public function update($new_instance, $old_instance) {
		$instance 				= $old_instance;
		$instance['title'] 		= $new_instance['title'];
		$instance['class_wrap'] = $new_instance['class_wrap'];
		$instance['info_style'] = $new_instance['info_style'];
		$instance['text'] 		= $new_instance['text'];
		$instance['address'] 	= $new_instance['address'];
		$instance['phone'] 		= $new_instance['phone'];
		$instance['mobile'] 	= $new_instance['mobile'];
		$instance['fax'] 		= $new_instance['fax'];
		$instance['email'] 		= $new_instance['email'];
		$instance['emailtxt']	= $new_instance['emailtxt'];
		$instance['web'] 		= $new_instance['web'];
		$instance['webtxt'] 	= $new_instance['webtxt'];
		$instance['skype'] 		= $new_instance['skype'];
		$instance['skypetxt'] 	= $new_instance['skypetxt'];
		return $instance;
	}

	public function form($instance) {
		$instance 	= wp_parse_args( (array) $instance, array(
			'title' 		=> __('Contact Info','kho'),
			'class_wrap' 	=> '',
			'info_style' 	=> __('Default','kho'),
			'text' 			=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur, aspernatur, velit. Adipisci, animi, molestiae, neque voluptatum non voluptas atque aperiam.',
			'address' 		=> __('Street Name, FL 54785','kho'),
			'phone' 		=> '621-254-2147',
			'mobile' 		=> '621-254-2147',
			'fax' 			=> '621-254-2147',
			'email' 		=> 'contact@support.com',
			'emailtxt' 		=> 'contact@support.com',
			'web' 			=> 'http://khositeweb.com/',
			'webtxt' 		=> 'Khositeweb',
			'skype' 		=> 'Khositeweb',
			'skypetxt' 		=> __('Skype Call Us','kho'),
		)); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('class_wrap'); ?>"><?php _e('Class Wrap (optional):', 'kho'); ?></label>			
			<input class="widefat" id="<?php echo $this->get_field_id('class_wrap'); ?>" name="<?php echo $this->get_field_name('class_wrap'); ?>" type="text" value="<?php echo $instance['class_wrap']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('info_style'); ?>"><?php _e('Style:', 'kho'); ?></label>
			<select class='uwl-widget-select widefat' name="<?php echo $this->get_field_name('info_style'); ?>" id="<?php echo $this->get_field_id('info_style'); ?>">
				<option value="default" <?php if($instance['info_style'] == 'default') { ?>selected="selected"<?php } ?>><?php _e( 'Default', 'kho' ); ?></option>
				<option value="big-icons" <?php if($instance['info_style'] == 'big-icons') { ?>selected="selected"<?php } ?>><?php _e( 'Big Icons', 'kho' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $instance['text']; ?>" />
		</p>
		<p class="uwl-left">
			<label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo $instance['address']; ?>" />
		</p>
		<p class="uwl-right">
			<label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $instance['phone']; ?>" />
		</p>
		<p class="uwl-left">
			<label for="<?php echo $this->get_field_id('mobile'); ?>"><?php _e('Mobile:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('mobile'); ?>" name="<?php echo $this->get_field_name('mobile'); ?>" value="<?php echo $instance['mobile']; ?>" />
		</p>
		<p class="uwl-right">
			<label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" value="<?php echo $instance['fax']; ?>" />
		</p>
		<p class="uwl-left">
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php echo $instance['email']; ?>" />
		</p>
		<p class="uwl-right">
			<label for="<?php echo $this->get_field_id('emailtxt'); ?>"><?php _e('Email Link Text:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('emailtxt'); ?>" name="<?php echo $this->get_field_name('emailtxt'); ?>" value="<?php echo $instance['emailtxt']; ?>" />
		</p>
		<p class="uwl-left">
			<label for="<?php echo $this->get_field_id('web'); ?>"><?php _e('Website URL (with HTTP):', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('web'); ?>" name="<?php echo $this->get_field_name('web'); ?>" value="<?php echo $instance['web']; ?>" />
		</p>
		<p class="uwl-right">
			<label for="<?php echo $this->get_field_id('webtxt'); ?>"><?php _e('Website URL Text:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('webtxt'); ?>" name="<?php echo $this->get_field_name('webtxt'); ?>" value="<?php echo $instance['webtxt']; ?>" />
		</p>
		<p class="uwl-left">
			<label for="<?php echo $this->get_field_id('skype'); ?>"><?php _e('Skype:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" value="<?php echo $instance['skype']; ?>" />
		</p>
		<p class="uwl-right">
			<label for="<?php echo $this->get_field_id('skypetxt'); ?>"><?php _e('Skype Text:', 'kho'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('skypetxt'); ?>" name="<?php echo $this->get_field_name('skypetxt'); ?>" value="<?php echo $instance['skypetxt']; ?>" />
		</p>

		<p style="background: #fcfcfc; padding: 10px; border: 1px solid #e3e3e3; text-align: center; text-transform: uppercase;"><?php _e( 'More Widgets?', 'kho' ); ?> <a href="http://codecanyon.net/item/ultimate-widgets-wordpress-plugin/12007937?ref=Khothemes" target="_blank"><?php _e( 'Buy the PRO version', 'kho' ); ?></a></p>
	<?php
	}
}