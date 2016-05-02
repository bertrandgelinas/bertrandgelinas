<?php

add_filter('wp_head', 'fifu_add_social_tags');

function fifu_add_social_tags() {
	$url = get_post_meta(get_the_ID(), 'fifu_image_url', true);
	$post_id = get_the_ID();
	$title = get_the_title($post_id);
	$description = wp_strip_all_tags(get_post_field('post_content', $post_id));

	if ($url)
		include 'html/social.html';
}

add_filter('post_thumbnail_html', 'fifu_replace', 10, 2);

function fifu_replace($html, $post_id) {
	$image_url = get_post_meta($post_id, 'fifu_image_url', true);
	$image_alt = get_post_meta($post_id, 'fifu_image_alt', true);

	if ($image_url)
		$html = fifu_get_html($image_url, $image_alt);

	return $html;
}

function fifu_get_html($image_url, $image_alt) {
	return sprintf('<!-- Featured Image From URL plugin --> <img src="%s" alt="%s"></img>', $image_url, $image_alt);
}

add_filter('the_content', 'fifu_add_to_content');

function fifu_add_to_content($content) {
	if (is_singular() && has_post_thumbnail() && get_option('fifu_content') == 'toggleon')
		return get_the_post_thumbnail() . $content;
	else
		return $content;
}

add_filter('wp_get_attachment_url', 'fifu_replace_attachment_url', 10, 2);

function fifu_replace_attachment_url($att_url, $att_id) {
	if (get_option('fifu_attachment_id') == $att_id) {
		if (is_admin())
			$att_url = '/wp-content/plugins/featured-image-from-url/admin/images/fifu-text.jpg';
		else {
			$url = get_post_meta(get_the_ID(), 'fifu_image_url', true);
			if ($url)
				$att_url = $url;
		}
	}
	return $att_url;
}
