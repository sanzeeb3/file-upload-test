<?php

/*
 * Plugin Name: File Upload Test Plugin
 * Description: Understanding file upload mechanism with testing.
 * Version: 1.0.0
 * Author: XYZ
 * Author URI: http://xyz.com.np
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function my_init_method() {	
 	wp_register_style ( 'mysample', plugins_url ( 'assets/css/custom.css', __FILE__ ) );
}
	
add_action('wp_enqueue_scripts', 'my_init_method');

function registration_form_view() {
      
  	echo    
        '<fieldset>
  	  			<legend>File Upload Test Form</legend>
                    <form id="file-upload-test-form" action="' . $_SERVER['REQUEST_URI'] . '" method="POST" enctype="multipart/form-data">
                        
                        <label>Username:<span style="color:red">*</span></label>
  					    <input name="username" type="text" value="' . ( isset( $_POST['username']) ? $_POST['username'] : null ) . '" required>
                        <input class="btn btn-default" name="submit" type="submit" value="submit">
  				    </form>

  		</fieldset>';

  }
 
add_shortcode('file-upload-test','shortcode_function');

function shortcode_function() {
    ob_start();
    registration_form_view();
    return ob_get_clean();
}
?>