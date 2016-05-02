<?php
// Widgets Functions

/*-----------------------------------------------------------------------------------*/
/*	- Widgets
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'uwl_custom_widgets' ) ) {
	function uwl_custom_widgets() {

		// Define array of custom widgets
		$widgets = array(
			'about-me',
			'contact-info',
			'flickr',
			'instagram',
			'mailchimp',
			'menu',
		);

		// Apply filters so you can remove custom widgets via a child theme if wanted
		$widgets = apply_filters( 'custom_widgets', $widgets );

		// Loop through widgets and load their files
		foreach ( $widgets as $widget ) {
			$widget_file = UWL_PLUGIN_DIR .'/widgets/widget-'. $widget .'.php';
			if ( file_exists( $widget_file ) ) {
				require_once( $widget_file );
			}
		}

	}
}

/*-----------------------------------------------------------------------------------*/
/*	- Register Widgets
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'register_uwl_widgets' ) ) {
	function register_uwl_widgets() {
		if ( '1' == uwl_option( 'about-me', '1' ) ) {
		    register_widget('uwl_about_me');
		}
		if ( '1' == uwl_option( 'contact-info', '1' ) ) {
		    register_widget('uwl_contact_info');
		}
		if ( '1' == uwl_option( 'flickr', '1' ) ) {
		    register_widget('uwl_flickr');
		}
		if ( '1' == uwl_option( 'instagram', '1' ) ) {
		    register_widget('uwl_instagram');
		}
		if ( '1' == uwl_option( 'mailchimp', '1' ) ) {
		    register_widget('uwl_mailchimp');
		}
		if ( '1' == uwl_option( 'menu', '1' ) ) {
		    register_widget('uwl_menu');
		}

	}
}
add_action('widgets_init', 'register_uwl_widgets');

/*-----------------------------------------------------------------------------------*/
/*	- Instagram Widget Function
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'uwl_scrape_instagram' ) ) {
	function uwl_scrape_instagram( $username, $slice = 9 ) {
		$username = strtolower( $username );

		if ( false === ( $instagram = get_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ) ) ) ) {
			$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );

			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'kho' ) );

			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', __( 'Instagram did not return a 200.', 'kho' ) );

			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], TRUE );

			if ( !$insta_array )
				return new WP_Error( 'bad_json', __( 'Instagram has returned invalid data.', 'kho' ) );

			// old style
			if ( isset( $insta_array['entry_data']['UserProfile'][0]['userMedia'] ) ) {
				$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];
				$type = 'old';
			// new style
			} else if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				$type = 'new';
			} else {
				return new WP_Error( 'bad_josn_2', __( 'Instagram has returned invalid data.', 'kho' ) );
			}

			if ( !is_array( $images ) )
				return new WP_Error( 'bad_array', __( 'Instagram has returned invalid data.', 'kho' ) );

			$instagram = array();
			switch ( $type ) {
				case 'old':
					foreach ( $images as $image ) {
						if ( $image['user']['username'] == $username ) {
							$image['link']						  	= preg_replace( "/^http:/i", "", $image['link'] );
							$image['images']['thumbnail']		   	= preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
							$image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
							$image['images']['low_resolution']	  	= preg_replace( "/^http:/i", "", $image['images']['low_resolution'] );

							$instagram[] = array(
								'description'   => $image['caption']['text'],
								'link'		  	=> $image['link'],
								'time'		  	=> $image['created_time'],
								'comments'	  	=> $image['comments']['count'],
								'likes'		 	=> $image['likes']['count'],
								'thumbnail'	 	=> $image['images']['thumbnail'],
								'large'		 	=> $image['images']['standard_resolution'],
								'small'		 	=> $image['images']['low_resolution'],
								'type'		  	=> $image['type']
							);
						}
					}
				break;
				default:
					foreach ( $images as $image ) {
						$image['display_src'] = preg_replace( "/^http:/i", "", $image['display_src'] );

						if ( $image['is_video']  == true ) {
							$type = 'video';
						} else {
							$type = 'image';
						}

						$instagram[] = array(
							'description'   => __( 'Instagram Image', 'kho' ),
							'link'		  	=> '//instagram.com/p/' . $image['code'],
							'time'		  	=> $image['date'],
							'comments'	  	=> $image['comments']['count'],
							'likes'		 	=> $image['likes']['count'],
							'thumbnail'	 	=> $image['display_src'],
							'type'		  	=> $type
						);
					}
				break;
			}

			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'instagram-media-new-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
			}
		}

		if ( ! empty( $instagram ) ) {
			$instagram = unserialize( base64_decode( $instagram ) );
			return array_slice( $instagram, 0, $slice );
		} else {
			return new WP_Error( 'no_images', __( 'Instagram did not return any images.', 'kho' ) );
		}
	}
}