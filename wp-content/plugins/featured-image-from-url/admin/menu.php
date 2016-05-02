<?php

add_action('admin_menu', 'fifu_insert_menu');

function fifu_insert_menu() {
	add_menu_page(
			'Featured Image From URL', 
			'Featured Image From URL', 
			'administrator', 
			'featured-image-from-url', 
			'fifu_get_menu_html', 
			plugins_url() . '/featured-image-from-url/admin/images/favicon.png'
	); 

	add_action('admin_init', 'fifu_get_menu_settings');
}

function fifu_get_menu_html() {
	$image_button = plugins_url() . '/featured-image-from-url/admin/images/onoff.jpg';

	$enable_woocommerce = get_option('fifu_woocommerce');
	$enable_content = get_option('fifu_content');

	$array_cpt = array();
	for ($x = 0; $x <= 4; $x++)
		$array_cpt[$x] = get_option('fifu_cpt' . $x);

	$show_woocommerce_button = $show_content_button = "display:block";
	$output = shell_exec('uname -s');
	if ($output == "") {
		$compatible = "Unfortunatelly, the script and your server system are not compatible =/";
		$show_woocommerce_button = "display:none";
	} else {
		if (strpos($output, "Linux") !== false)
			$compatible = "You server is using $output system. Great! The script will work =)";
		else
			$compatible = "You server is using $output system. The script may work. <p/>Please, send an email to <a href='mailto:contact@marceljm.com'>contact@marceljm.com</a> informing your server system and let me know if it worked for you.";
	}

	include 'html/menu.html';

	fifu_update_menu_options();

	fifu_script_woocommerce();
}

function fifu_get_menu_settings() {
	fifu_get_setting('fifu_woocommerce');
	fifu_get_setting('fifu_content');

	for ($x = 0; $x <= 4; $x++)
		fifu_get_setting('fifu_cpt' . $x); 
}

function fifu_get_setting($type) {
	register_setting('settings-group', $type);

	if (!get_option($type)) {
		if (strpos($type, "cpt") !== false)
			update_option($type, '');
		else
			update_option($type, 'toggleoff');
	}
}

function fifu_update_menu_options() {
	fifu_update_option('fifu_input_woocommerce', 'fifu_woocommerce');
	fifu_update_option('fifu_input_content', 'fifu_content');

	for ($x = 0; $x <= 4; $x++)
		fifu_update_option('fifu_input_cpt' . $x, 'fifu_cpt' . $x);
}

function fifu_update_option($input, $type) {
	if (isset($_POST[$input])) {
		if ($_POST[$input] == 'on') 
			update_option($type, 'toggleon');
		else if ($_POST[$input] == 'off')
			update_option($type, 'toggleoff');
		else 
			update_option($type, wp_strip_all_tags($_POST[$input]));
	}
}

function fifu_script_woocommerce() {
	if (get_option('fifu_woocommerce') == 'toggleon') {
		$command1 = "echo " . get_template_directory() . " > ../wp-content/plugins/featured-image-from-url/scripts/tmp.txt";
		$command2 = "sh ../wp-content/plugins/featured-image-from-url/scripts/enableWoocommerce.sh";
	}
	else {
		$command1 = "sh ../wp-content/plugins/featured-image-from-url/scripts/disableWoocommerce.sh";
		$command2 = "rm ../wp-content/plugins/featured-image-from-url/scripts/tmp.txt";
	}
	shell_exec($command1);
	shell_exec($command2);
}
