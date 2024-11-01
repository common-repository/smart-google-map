<?php

add_action('admin_menu', 'sgm_settings_create_menu');

function sgm_settings_create_menu() {

 	add_submenu_page(
        'edit.php?post_type=smart-google-map',
        __( 'Settings', 'smart-google-map' ),
        __( 'Settings', 'smart-google-map' ),
        'manage_options',
        'sgm-settings',
        'sgm_settings_page_callback'
    );
	
	add_action( 'admin_init', 'register_sgm_settings' );
}

function register_sgm_settings(){
	register_setting( 'sgm-settings-group', 'google_map_api_key' );
}

function sgm_settings_page_callback(){
?>
<style type="text/css">
	.form-table input{
		width: 400px;
		max-width: 100%;
	}
	span.shortcode > input {
	    background: inherit;
	    color: inherit;
	    font-size: 12px;
	    border: none;
	    box-shadow: none;
	    padding: 4px 8px;
	    margin: 0;
	}
</style>
<div class="wrap">
<h1>Smart Google Map Settings</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'sgm-settings-group' ); ?>
    <?php do_settings_sections( 'sgm-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Google Map API Key</th>
        <td><input type="text" name="google_map_api_key" value="<?php echo esc_attr( get_option('google_map_api_key') ); ?>" />
        	<p><em>* Create or use your own Google API Key</em></p>
        </td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>

<hr/>
	<div class="card">
		<table class="form-table">
	        <tr valign="top">
	        <th scope="row">Shortcode</th>
	        <td><span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value='[smart-google-map]' class="large-text code"></span></td>
	        </tr>
	    </table>
	    <p><em>Note: Don't use shortcode more than one time on one page </em></p>
	</div>
</div>
<?php
}

?>