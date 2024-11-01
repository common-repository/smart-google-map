<?php

add_action('add_meta_boxes','sgm_meta_box_init');

function sgm_meta_box_init(){
	add_meta_box('sgm-meta-box','Other Details','sgm_meta_box_ctr', 'smart-google-map' ,'normal','default');
}

function sgm_meta_box_ctr(){
	global $post;
	wp_nonce_field(basename(__FILE__),'sgm_meta_box_nonce');
	?>
	<h3>Position</h3>
	<table border="0" cellpadding="0" cellspacing="10">
		<tbody>
			<tr>
				<td>Latitude (Lat):</td>
				<td><input type="number" step=any name="sgm-marker-lat" value="<?php esc_attr_e(get_post_meta($post->ID, 'sgm-marker-lat', true), 'smart-google-map'); ?>" required></td>
			</tr>
			<tr>
				<td>Longitude (Lng):</td>
				<td><input type="number" step=any name="sgm-marker-lng" value="<?php esc_attr_e(get_post_meta($post->ID, 'sgm-marker-lng', true), 'smart-google-map'); ?>" required></td>
			</tr>
		</tbody>
	</table>
	<?php
}


add_action('save_post','sgm_meta_box_save',10,2);

function sgm_meta_box_save($post_id, $post){
	if(!isset($_POST['sgm_meta_box_nonce'])|| !wp_verify_nonce($_POST['sgm_meta_box_nonce'], basename(__FILE__)))
		return $post_id;
	
	if(!current_user_can('edit_post', $post->ID))
		return $post_id;

	update_post_meta($post_id, 'sgm-marker-lat', sanitize_text_field($_POST['sgm-marker-lat']));
	update_post_meta($post_id, 'sgm-marker-lng', sanitize_text_field($_POST['sgm-marker-lng']));

}

?>