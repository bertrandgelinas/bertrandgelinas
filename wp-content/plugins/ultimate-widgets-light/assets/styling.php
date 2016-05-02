<?php
// All Custom CSS

/*-----------------------------------------------------------------------------------*/
/*	- Style Widgets
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'uwl_style_widgets' ) ) {
	function uwl_style_widgets() {
		// Var
		$css = '';

		/**
		   Widget Style 1
		**/
		// Border color
		$style1_border_color = uwl_option( 'style1_border_color' );
		if ( '' != $style1_border_color && '#e0e0e0' != $style1_border_color ) {
			$css .= '.uwl_widget_wrap.style1 {border-color: '. $style1_border_color .';}';
		}

		// Padding
		$style1_padding = uwl_option( 'style1_padding' );
		if ( '' != $style1_padding && '16px' != $style1_padding ) {
			$css .= '.uwl_widget_wrap.style1 {padding: '. $style1_padding .' !important;}
					.uwl_widget_wrap.style1 .uwl-title {top: -'. $style1_padding .';}';
		}

		// Margin bottom
		$style1_margin_bottom = uwl_option( 'style1_margin_bottom' );
		if ( '' != $style1_margin_bottom && '40px' != $style1_margin_bottom ) {
			$css .= '.uwl_widget_wrap.style1, .uwl_tabs_widget {margin-bottom: '. $style1_margin_bottom .';}';
		}

		// Title background
		$style1_title_bg = uwl_option( 'style1_title_bg' );
		if ( '' != $style1_title_bg && '#e7f1ff' != $style1_title_bg ) {
			$css .= '.uwl_widget_wrap.style1 .uwl-title span {background: '. $style1_title_bg .';}';
		}

		// Title color
		$style1_title_color = uwl_option( 'style1_title_color' );
		if ( '' != $style1_title_color && '#2676ef' != $style1_title_color ) {
			$css .= '.uwl_widget_wrap.style1 .uwl-title {color: '. $style1_title_color .';}';
		}

		// Title font size
		$style1_title_font_size = uwl_option( 'style1_title_font_size' );
		if ( '' != $style1_title_font_size && '10px' != $style1_title_font_size ) {
			$css .= '.uwl_widget_wrap.style1 .uwl-title {font-size: '. $style1_title_font_size .';}';
		}

		/**
		   Widget Style 2
		**/
		// Margin bottom
		$style2_margin_bottom = uwl_option( 'style2_margin_bottom' );
		if ( '' != $style2_margin_bottom && '50px' != $style2_margin_bottom ) {
			$css .= '.uwl_widget_wrap.style2, .uwl_tabs_widget {margin-bottom: '. $style2_margin_bottom .';}';
		}
		
		// Title color
		$style2_title_color = uwl_option( 'style2_title_color' );
		if ( '' != $style2_title_color && '#333' != $style2_title_color ) {
			$css .= '.uwl_widget_wrap.style2 .uwl-title {color: '. $style2_title_color .';}';
		}

		// Title font size
		$style2_title_font_size = uwl_option( 'style2_title_font_size' );
		if ( '' != $style2_title_font_size && '16px' != $style2_title_font_size ) {
			$css .= '.uwl_widget_wrap.style2 .uwl-title {font-size: '. $style2_title_font_size .';}';
		}

		// Title border color
		$style2_title_border_color = uwl_option( 'style2_title_border_color' );
		if ( '' != $style2_title_border_color && '#4dbefa' != $style2_title_border_color ) {
			$css .= '.uwl_widget_wrap.style2 .uwl-title::after {border-color: '. $style2_title_border_color .';}';
		}

		// Title border width
		$style2_title_border_width = uwl_option( 'style2_title_border_width' );
		if ( '' != $style2_title_border_width && '40%' != $style2_title_border_width ) {
			$css .= '.uwl_widget_wrap.style2 .uwl-title::after {width: '. $style2_title_border_width .';}';
		}

		/**
		   Widget Style 3
		**/
		// Margin bottom
		$style3_margin_bottom = uwl_option( 'style3_margin_bottom' );
		if ( '' != $style3_margin_bottom && '30px' != $style3_margin_bottom ) {
			$css .= '.uwl_widget_wrap.style3, .uwl_tabs_widget {margin-bottom: '. $style3_margin_bottom .';}';
		}
		
		// Title background
		$style3_title_bg = uwl_option( 'style3_title_bg' );
		if ( '' != $style3_title_bg && '#f2f2f2' != $style3_title_bg ) {
			$css .= '.uwl_widget_wrap.style3 .uwl-title {background-color: '. $style3_title_bg .';}';
		}

		// Title color
		$style3_title_color = uwl_option( 'style3_title_color' );
		if ( '' != $style3_title_color && '#666' != $style3_title_color ) {
			$css .= '.uwl_widget_wrap.style3 .uwl-title {color: '. $style3_title_color .';}';
		}

		// Title font size
		$style3_title_font_size = uwl_option( 'style3_title_font_size' );
		if ( '' != $style3_title_font_size && '18px' != $style3_title_font_size ) {
			$css .= '.uwl_widget_wrap.style3 .uwl-title {font-size: '. $style3_title_font_size .';}';
		}

		// Title border color
		$style3_title_border_color = uwl_option( 'style3_title_border_color' );
		if ( '' != $style3_title_border_color && '#4dbefa' != $style3_title_border_color ) {
			$css .= '.uwl_widget_wrap.style3 .uwl-title {border-color: '. $style3_title_border_color .';}';
		}

		/**
		   Links Color
		**/
		$links_color = uwl_option( 'custom_links_color' );
		if ( '' != $links_color && '#333' != $links_color ) {
			$css .= 'body .uwl_widget_wrap a {color: '. $links_color .';}';
		}

		// Links hover Color
		$links_hover_color = uwl_option( 'custom_links_hover_color' );
		if ( '' != $links_hover_color && '#4dbefa' != $links_hover_color ) {
			$css .= 'body .uwl_widget_wrap a:hover {color: '. $links_hover_color .';}';
		}

		/**
		   Inputs Styles
		**/
		// Input background
		$input_bg = uwl_option( 'input_bg' );
		$input_bg_regular = $input_bg['regular'];
		if ( '' != $input_bg_regular && '#fff' != $input_bg_regular ) {
			$css .= '.uwl_widget_wrap input[type="text"], .uwl_widget_wrap input[type="password"], .uwl_widget_wrap input[type="email"], .uwl_widget_wrap input[type="search"] {background-color: '. $input_bg_regular .';}';
		}
		$input_bg_hover = $input_bg['hover'];
		if ( '' != $input_bg_hover && '#fff' != $input_bg_hover ) {
			$css .= '.uwl_widget_wrap input[type="text"]:hover, .uwl_widget_wrap input[type="password"]:hover, .uwl_widget_wrap input[type="email"]:hover, .uwl_widget_wrap input[type="search"]:hover {background-color: '. $input_bg_hover .';}';
		}
		$input_bg_active = $input_bg['active'];
		if ( '' != $input_bg_active && '#fff' != $input_bg_active ) {
			$css .= '.uwl_widget_wrap input[type="text"]:focus, .uwl_widget_wrap input[type="password"]:focus, .uwl_widget_wrap input[type="email"]:focus, .uwl_widget_wrap input[type="search"]:focus {background-color: '. $input_bg_active .';}';
		}

		// Input color
		$input_color = uwl_option( 'input_color' );
		if ( '' != $input_color && '#888' != $input_color ) {
			$css .= '.uwl_widget_wrap input[type="text"], .uwl_widget_wrap input[type="password"], .uwl_widget_wrap input[type="email"], .uwl_widget_wrap input[type="search"] {color: '. $input_color .';}';
		}

		// Input border color
		$input_border = uwl_option( 'input_border' );
		$input_border_regular = $input_border['regular'];
		if ( '' != $input_border_regular && '#e0e0e0' != $input_border_regular ) {
			$css .= '.uwl_widget_wrap input[type="text"], .uwl_widget_wrap input[type="password"], .uwl_widget_wrap input[type="email"], .uwl_widget_wrap input[type="search"], .uwl_login_widget .input-append .show-pass {border-color: '. $input_border_regular .';}';
		}
		$input_border_hover = $input_border['hover'];
		if ( '' != $input_border_hover && '#c1c1c1' != $input_border_hover ) {
			$css .= '.uwl_widget_wrap input[type="text"]:hover, .uwl_widget_wrap input[type="password"]:hover, .uwl_widget_wrap input[type="email"]:hover, .uwl_widget_wrap input[type="search"]:hover {border-color: '. $input_border_hover .';}';
		}
		$input_border_active = $input_border['active'];
		if ( '' != $input_border_active && '#4dbefa' != $input_border_active ) {
			$css .= '.uwl_widget_wrap input[type="text"]:focus, .uwl_widget_wrap input[type="password"]:focus, .uwl_widget_wrap input[type="email"]:focus, .uwl_widget_wrap input[type="search"]:focus {border-color: '. $input_border_active .';}';
		}

		/**
		   Buttons Styles
		**/
		// Input submit background
		$input_submit_bg = uwl_option( 'input_submit_bg' );
		$input_submit_bg_regular = $input_submit_bg['regular'];
		if ( '' != $input_submit_bg_regular && '#4dbefa' != $input_submit_bg_regular ) {
			$css .= '.uwl_widget_wrap input[type="submit"] {background-color: '. $input_submit_bg_regular .';}';
		}
		$input_submit_bg_hover = $input_submit_bg['hover'];
		if ( '' != $input_submit_bg_hover ) {
			$css .= '.uwl_widget_wrap input[type="submit"]:hover {background-color: '. $input_submit_bg_hover .';}';
		}
		$input_submit_bg_active = $input_submit_bg['active'];
		if ( '' != $input_submit_bg_active && '#4dbefa' != $input_submit_bg_active ) {
			$css .= '.uwl_widget_wrap input[type="submit"]:active {background-color: '. $input_submit_bg_active .';}';
		}

		// Input submit color
		$input_submit_color = uwl_option( 'input_submit_color' );
		$input_submit_color_regular = $input_submit_color['regular'];
		if ( '' != $input_submit_color_regular && '#fff' != $input_submit_color_regular ) {
			$css .= '.uwl_widget_wrap input[type="submit"] {color: '. $input_submit_color_regular .';}';
		}
		$input_submit_color_hover = $input_submit_color['hover'];
		if ( '' != $input_submit_color_hover && '#4dbefa' != $input_submit_color_hover ) {
			$css .= '.uwl_widget_wrap input[type="submit"]:hover {color: '. $input_submit_color_hover .';}';
		}
		$input_submit_color_active = $input_submit_color['active'];
		if ( '' != $input_submit_color_active && '#4dbefa' != $input_submit_color_active ) {
			$css .= '.uwl_widget_wrap input[type="submit"]:active {color: '. $input_submit_color_active .';}';
		}

		// Input submit border color
		$input_submit_border = uwl_option( 'input_submit_border' );
		$input_submit_border_regular = $input_submit_border['regular'];
		if ( '' != $input_submit_border_regular && '#4dbefa' != $input_submit_border_regular ) {
			$css .= '.uwl_widget_wrap input[type="submit"] {border-color: '. $input_submit_border_regular .';}';
		}
		$input_submit_border_hover = $input_submit_border['hover'];
		if ( '' != $input_submit_border_hover && '#4dbefa' != $input_submit_border_hover ) {
			$css .= '.uwl_widget_wrap input[type="submit"]:hover {border-color: '. $input_submit_border_hover .';}';
		}
		$input_submit_border_active = $input_submit_border['active'];
		if ( '' != $input_submit_border_active && '#4dbefa' != $input_submit_border_active ) {
			$css .= '.uwl_widget_wrap input[type="submit"]:active {border-color: '. $input_submit_border_active .';}';
		}
		
		/**
		   Contact Info Widget
		**/
		// Default style icons color
		$default_style_icons_color = uwl_option( 'default_style_icons_color' );
		if ( '' != $default_style_icons_color && '#01aef0' != $default_style_icons_color ) {
			$css .= '.uwl_contact_info_widget .default i {color: '. $default_style_icons_color .';}';
		}

		// Default style icons border color
		$default_style_icons_border_color = uwl_option( 'default_style_icons_border_color' );
		if ( '' != $default_style_icons_border_color && '#e2e2e2' != $default_style_icons_border_color ) {
			$css .= '.uwl_contact_info_widget .default i {border-color: '. $default_style_icons_border_color .';}';
		}

		// Default style titles color
		$default_style_titles_color = uwl_option( 'default_style_titles_color' );
		if ( '' != $default_style_titles_color && '#777' != $default_style_titles_color ) {
			$css .= '.uwl_contact_info_widget .default span.uwl-contact-title {color: '. $default_style_titles_color .';}';
		}

		// Big icons style icons background
		$big_icons_style_icons_bg = uwl_option( 'big_icons_style_icons_bg' );
		$big_icons_style_icons_bg_regular = $big_icons_style_icons_bg['regular'];
		if ( '' != $big_icons_style_icons_bg_regular ) {
			$css .= '.uwl_contact_info_widget .big-icons i {background-color: '. $big_icons_style_icons_bg_regular .';}';
		}
		$big_icons_style_icons_bg_hover = $big_icons_style_icons_bg['hover'];
		if ( '' != $big_icons_style_icons_bg_hover && '#01aef0' != $big_icons_style_icons_bg_hover ) {
			$css .= '.uwl_contact_info_widget .big-icons li:hover i {background-color: '. $big_icons_style_icons_bg_hover .';}';
		}
		$big_icons_style_icons_bg_active = $big_icons_style_icons_bg['active'];
		if ( '' != $big_icons_style_icons_bg_active ) {
			$css .= '.uwl_contact_info_widget .big-icons li:active i {background-color: '. $big_icons_style_icons_bg_active .';}';
		}

		// Big icons style icons color
		$big_icons_style_icons_color = uwl_option( 'big_icons_style_icons_color' );
		$big_icons_style_icons_color_regular = $big_icons_style_icons_color['regular'];
		if ( '' != $big_icons_style_icons_color_regular && '#01aef0' != $big_icons_style_icons_color_regular ) {
			$css .= '.uwl_contact_info_widget .big-icons i {color: '. $big_icons_style_icons_color_regular .';}';
		}
		$big_icons_style_icons_color_hover = $big_icons_style_icons_color['hover'];
		if ( '' != $big_icons_style_icons_color_hover && '#fff' != $big_icons_style_icons_color_hover ) {
			$css .= '.uwl_contact_info_widget .big-icons li:hover i {color: '. $big_icons_style_icons_color_hover .';}';
		}
		$big_icons_style_icons_color_active = $big_icons_style_icons_color['active'];
		if ( '' != $big_icons_style_icons_color_active ) {
			$css .= '.uwl_contact_info_widget .big-icons li:active i {color: '. $big_icons_style_icons_color_active .';}';
		}

		// Big icons style icons border color
		$big_icons_style_icons_border_color = uwl_option( 'big_icons_style_icons_border_color' );
		$big_icons_style_icons_border_color_regular = $big_icons_style_icons_border_color['regular'];
		if ( '' != $big_icons_style_icons_border_color_regular && '#01aef0' != $big_icons_style_icons_border_color_regular ) {
			$css .= '.uwl_contact_info_widget .big-icons i {border-color: '. $big_icons_style_icons_border_color_regular .';}';
		}
		$big_icons_style_icons_border_color_hover = $big_icons_style_icons_border_color['hover'];
		if ( '' != $big_icons_style_icons_border_color_hover && '#01aef0' != $big_icons_style_icons_border_color_hover ) {
			$css .= '.uwl_contact_info_widget .big-icons li:hover i {border-color: '. $big_icons_style_icons_border_color_hover .';}';
		}
		$big_icons_style_icons_border_color_active = $big_icons_style_icons_border_color['active'];
		if ( '' != $big_icons_style_icons_border_color_active ) {
			$css .= '.uwl_contact_info_widget .big-icons li:active i {border-color: '. $big_icons_style_icons_border_color_active .';}';
		}

		// Big icons style titles color
		$big_icons_style_titles_color = uwl_option( 'big_icons_style_titles_color' );
		if ( '' != $big_icons_style_titles_color ) {
			$css .= '.uwl_contact_info_widget .big-icons span.uwl-contact-title {color: '. $big_icons_style_titles_color .';}';
		}

		// Skype background
		$contact_info_skype_bg = uwl_option( 'contact_info_skype_bg' );
		$contact_info_skype_bg_regular = $contact_info_skype_bg['regular'];
		if ( '' != $contact_info_skype_bg_regular && '#00AFF0' != $contact_info_skype_bg_regular ) {
			$css .= '.uwl_contact_info_widget li.skype a {background-color: '. $contact_info_skype_bg_regular .';}';
		}
		$contact_info_skype_bg_hover = $contact_info_skype_bg['hover'];
		if ( '' != $contact_info_skype_bg_hover && '#333' != $contact_info_skype_bg_hover ) {
			$css .= '.uwl_contact_info_widget li.skype a:hover {background-color: '. $contact_info_skype_bg_hover .';}';
		}
		$contact_info_skype_bg_active = $contact_info_skype_bg['active'];
		if ( '' != $contact_info_skype_bg_active ) {
			$css .= '.uwl_contact_info_widget li.skype a:active {background-color: '. $contact_info_skype_bg_active .';}';
		}

		// Skype color
		$contact_info_skype_color = uwl_option( 'contact_info_skype_color' );
		$contact_info_skype_color_regular = $contact_info_skype_color['regular'];
		if ( '' != $contact_info_skype_color_regular && '#fff' != $contact_info_skype_color_regular ) {
			$css .= '.uwl_contact_info_widget li.skype a {color: '. $contact_info_skype_color_regular .'!important;}';
		}
		$contact_info_skype_color_hover = $contact_info_skype_color['hover'];
		if ( '' != $contact_info_skype_color_hover && '#fff' != $contact_info_skype_color_hover ) {
			$css .= '.uwl_contact_info_widget li.skype a:hover {color: '. $contact_info_skype_color_hover .'!important;}';
		}
		$contact_info_skype_color_active = $contact_info_skype_color['active'];
		if ( '' != $contact_info_skype_color_active ) {
			$css .= '.uwl_contact_info_widget li.skype a:active {color: '. $contact_info_skype_color_active .'!important;}';
		}

		/**
		   Menu Widget
		**/
		// Menu link border bottom color
		$links_border_bottom = uwl_option( 'links_border_bottom' );
		if ( '' != $links_border_bottom && '#e0e0e0' != $links_border_bottom ) {
			$css .= '.uwl_menu_widget ul li {border-color: '. $links_border_bottom .';}';
		}

		// Sub icon color
		$sub_icon_color = uwl_option( 'sub_icon_color' );
		$sub_icon_color_regular = $sub_icon_color['regular'];
		if ( '' != $sub_icon_color_regular && '#aaa' != $sub_icon_color_regular ) {
			$css .= '.uwl_menu_widget li .uwl-sub-icon {color: '. $sub_icon_color_regular .';}';
		}
		$sub_icon_color_hover = $sub_icon_color['hover'];
		if ( '' != $sub_icon_color_hover && '#4dbefa' != $sub_icon_color_hover ) {
			$css .= '.uwl_menu_widget li .uwl-sub-icon:hover {color: '. $sub_icon_color_hover .';}';
		}
		$sub_icon_color_active = $sub_icon_color['active'];
		if ( '' != $sub_icon_color_active ) {
			$css .= '.uwl_menu_widget li .uwl-sub-icon:active {color: '. $sub_icon_color_active .';}';
		}

		/**
		   Output css on front end
		**/
		if ( '' != $css ) {
			$css =  preg_replace( '/\s+/', ' ', $css );
			$css = ''. $css .'';
			return $css;
		} else {
			return '';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/*	- Custom CSS
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'uwl_custom_css' ) ) {
	function uwl_custom_css() {
		$css = uwl_option( 'custom_css' );
		if ( '' != $css ) {
			$css =  preg_replace( '/\s+/', ' ', $css );
			$css = ''. $css .'';
			return $css;
		} else {
			return '';
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/*	- Output CSS
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'uwl_output_css' ) ) {
	function uwl_output_css() {
		// Set output Var
		$output = '';
		$output .= uwl_style_widgets();
		$output .= uwl_custom_css();

		if ( $output ) {
			echo "\n<style type=\"text/css\">\n" . $output . "\n</style>";
		}
	}
}
add_action( 'wp_head', 'uwl_output_css' );