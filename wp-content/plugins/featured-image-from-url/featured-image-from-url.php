<?php

/*
 * Plugin Name: Featured Image From URL
 * Description: Allows to use an external image as Featured Image of your post, page or Custom Post Type, such as WooCommerce Product (supports Product Gallery also).
 * Version: 1.3.2
 * Author: Marcel Jacques Machado 
 * Author URI: https://marceljm.com/wordpress/featured-image-from-url-premium/ 
 */

define('FIFU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FIFU_INCLUDES_DIR', FIFU_PLUGIN_DIR . '/includes');
define('FIFU_ADMIN_DIR', FIFU_PLUGIN_DIR . '/admin');

require_once( FIFU_INCLUDES_DIR . '/thumbnail.php' );
require_once( FIFU_INCLUDES_DIR . '/thumbnail-category.php' );

if (is_admin()) {
	require_once( FIFU_ADMIN_DIR . '/meta-box.php' );
	require_once( FIFU_ADMIN_DIR . '/menu.php' );
	require_once( FIFU_ADMIN_DIR . '/column.php' );
	require_once( FIFU_ADMIN_DIR . '/category.php' );
}

register_deactivation_hook( __FILE__, 'fifu_desactivate' );

function fifu_desactivate() {
	update_option('fifu_woocommerce', 'toggleoff');
	shell_exec('sh ../wp-content/plugins/featured-image-from-url/scripts/disableWoocommerce.sh');
	wp_delete_attachment(get_option('fifu_attachment_id'));
}

register_activation_hook(__FILE__, 'fifu_activate');

function fifu_activate() {
	global $wpdb;
	$old_attach_id = get_option('fifu_attachment_id');

	/* create attachment */
	$filename = 'Featured Image From URL';
	$parent_post_id = null;
	$filetype = wp_check_filetype('anything.jpg', null);
	$attachment = array(
		'guid' => basename($filename),
		'post_mime_type' => $filetype['type'],
		'post_title' => '',
		'post_excerpt' => '',
		'post_content' => 'Please don\'t remove that. It\'s just a symbolic file that keeps the field filled. Some themes depend on having an attached file to work. But you are free to use any image you want instead of this file.',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	$attach_data = wp_generate_attachment_metadata($attach_id, $filename);
	wp_update_attachment_metadata($attach_id, $attach_data);
	update_option('fifu_attachment_id', $attach_id);

	/* insert _thumbnail_id */
	$table = $wpdb->prefix . 'postmeta';
	$query = "
		SELECT DISTINCT post_id
		FROM " . $table . " a
		WHERE a.post_id in (
			SELECT post_id 
			FROM " . $table . " b 
			WHERE b.meta_key = 'fifu_image_url' 
			AND b.meta_value IS NOT NULL 
			AND b.meta_value <> ''
		)
		AND NOT EXISTS (
			SELECT 1 
			FROM " . $table . " c 
			WHERE a.post_id = c.post_id 
			AND c.meta_key = '_thumbnail_id'
		)";
	$result = $wpdb->get_results($query);
	foreach ($result as $i) {
		$data = array('post_id' => $i->post_id, 'meta_key' => '_thumbnail_id', 'meta_value' => $attach_id);
		$wpdb->insert($table, $data);
	}

	/* update _thumbnail_id */
	$data = array('meta_value' => $attach_id);
	$where = array('meta_key' => '_thumbnail_id', 'meta_value' => $old_attach_id);
	$wpdb->update($table, $data, $where, null, null);

	/* update _thumbnail_id (to support old versions) */
	$query = "
		SELECT post_id 
		FROM " . $table . " a
		WHERE a.meta_key = 'fifu_image_url' 
		AND a.meta_value IS NOT NULL 
		AND a.meta_value <> ''";
	$result = $wpdb->get_results($query);
	foreach ($result as $i) {
		$data = array('meta_value' => $attach_id);
		$where = array('post_id' => $i->post_id, 'meta_key' => '_thumbnail_id', 'meta_value' => -1);
		$wpdb->update($table, $data, $where, null, null);
	}
}
