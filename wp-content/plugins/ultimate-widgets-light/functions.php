<?php
/*
Plugin Name: Ultimate Widgets Light
Plugin URI: http://khothemes.com/ultimate-widgets/
Description: Ultimate Widgets plugin allows you to add the most popular widgets like Ads, Contact Info, Facebook Page Plugin, Google Map, Testomonial, Twitter Widget, Social Widget, Soundclound, etc...
Author: Khothemes
Author URI: http://khothemes.com/
Text Domain: kho
Domain Path: /languages/
Version: 1.2.7
*/

/*  Copyright 2007-2015 Khothemes

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'UWL_PLUGIN', __FILE__ );
define( 'UWL_PLUGIN_DIR', untrailingslashit( dirname( UWL_PLUGIN ) ) );
define( 'UWL_VERSION', '1.2.7' );

function uwl_plugin_url( $path = '' ) {
	$url = plugins_url( $path, UWL_PLUGIN );

	if ( is_ssl() && 'http:' == substr( $url, 0, 5 ) ) {
		$url = 'https:' . substr( $url, 5 );
	}

	return $url;
}

/*-----------------------------------------------------------------------------------*/
/*	- Core functions
/*-----------------------------------------------------------------------------------*/
// Core functions
require_once ( UWL_PLUGIN_DIR .'/assets/core.php' );
require_once ( UWL_PLUGIN_DIR .'/assets/images-resize.php' );
require_once ( UWL_PLUGIN_DIR .'/assets/styling.php' );
require_once ( UWL_PLUGIN_DIR .'/assets/walker-nav.php' );
require_once ( UWL_PLUGIN_DIR .'/assets/widgets-functions.php' );

/*-----------------------------------------------------------------------------------*/
/*	- Language/Widgets
/*-----------------------------------------------------------------------------------*/
add_action( 'plugins_loaded', 'uwl_core' );
function uwl_core() {
	load_plugin_textdomain( 'kho', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	// ReduxFramework admin panel
	if ( function_exists( 'uwl_supports' ) && uwl_supports( 'primary', 'admin' ) ) {
		// Include the Redux options Framework
		if ( !class_exists( 'ReduxFramework' ) ) {
			require_once( UWL_PLUGIN_DIR .'/assets/admin/redux-core/framework.php' );
		}
		// Register all the main options
		require_once( UWL_PLUGIN_DIR .'/assets/admin/admin-config.php' );
	}
	uwl_custom_widgets();
}

/*-----------------------------------------------------------------------------------*/
/*	- Scripts
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'uwl_plugin_css' );
function uwl_plugin_css() {
	if ( '1' == uwl_option( 'minify_css', '1' ) ) {
		// Minified style
		wp_enqueue_style( 'uwl-style', uwl_plugin_url( 'assets/css/style-min.css' ), array(), UWL_VERSION);
	} else {
		// Core style
		wp_enqueue_style( 'uwl-style', uwl_plugin_url( 'assets/css/styles/core.css' ), array(), UWL_VERSION );

		// Responsive
		wp_enqueue_style( 'uwl-responsive', uwl_plugin_url( 'assets/css/styles/responsive.css' ) );
	}

	// RTL style
	if ( is_rtl() ) {
		wp_enqueue_style( 'ultimate-style-rtl', uwl_plugin_url( 'assets/css/styles-rtl-min.css' ), array(), UWL_VERSION );
	}
}

add_action( 'wp_footer', 'uwl_plugin_js' );
function uwl_plugin_js() {
	if ( '1' == uwl_option( 'minify_js', '1' ) ) {
		wp_enqueue_script('uwl-scripts', uwl_plugin_url( 'assets/js/scripts-min.js' ), array('jquery'), UWL_VERSION );
	}
}


add_action('admin_init', 'uwl_admin_style' );
function uwl_admin_style() {
	wp_enqueue_style( 'uwl-admin-style', uwl_plugin_url( 'assets/css/admin.css' ), array(), UWL_VERSION );
}

/*-----------------------------------------------------------------------------------*/
/*	- Notice
/*-----------------------------------------------------------------------------------*/
function uwl_nag() {
	global $current_user ;
    $user_id = $current_user->ID;

	if ( !get_user_meta( $user_id, 'ignore_uwl_notice' ) ) { ?>
        <div class="updated uwl-updated">
	        <div class="uwl-nag">
	        	<a class="uwl-close-icon notice-dismiss" href="?uwl_nag_dismiss=yes"></a>
	        	<div class="icon"><img title="" src="<?php echo uwl_plugin_url( 'assets/images/uw-avatar.png' ); ?>" alt="" /></div>
        		<div class="text">
	        		<?php _e( 'It’s time to upgrade', 'kho' ); ?> <strong>Ultimate Widgtes Light plugin</strong> <?php _e( 'to', 'kho' ); ?> <strong>PRO</strong> <?php _e( 'version!', 'kho'); ?>
	        		<span><?php _e( 'A multitude of widgets, several styles, unique, beautiful & original, don&rsquo;t wait!', 'kho' ); ?></span>
        		</div>
	        	<div class="uwl-button"><a target="_blank" href="http://codecanyon.net/item/ultimate-widgets-wordpress-plugin/12007937?ref=Khothemes"><?php _e( 'Download', 'kho' ); ?></a></div>
	        </div>
        </div>
	<?php
	}
}
add_action( 'admin_notices', 'uwl_nag' );

function kho_dismiss_admin_notice() {
	global $current_user;
	$user_id = $current_user->ID;

	// If "Dismiss" link has been clicked, user meta field is added
	if ( isset( $_GET['uwl_nag_dismiss'] ) && 'yes' == $_GET['uwl_nag_dismiss'] ) {
		add_user_meta( $user_id, 'ignore_uwl_notice', 'yes', true );
	}
}
add_action( 'admin_init', 'kho_dismiss_admin_notice' );

function kho_update_dismiss() {
	delete_metadata( 'user', false, 'ignore_uwl_notice', '', true );
}
add_action( 'activated_plugin', 'kho_update_dismiss', 10, 2 );