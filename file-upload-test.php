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
  					    <input name="username" type="text" required/>
                        <input type="file" name="image"/>
                        '. wp_nonce_field( 'save', 'file-upload-test-nonce' ) .'
                        <input class="btn btn-default" name="submit" type="submit" value="submit">
  				    </form>

  		</fieldset>';

  }

function process_data() {

    if ( isset ( $_POST['file-upload-test-nonce'] ) && wp_verify_nonce( $_POST['file-upload-test-nonce'], 'save' ) ) {
        if ( isset( $_FILES['image'] ) && $_FILES['image']['error'] === 0 ) {
            
            //upload file
            wp_upload_bits( $_FILES['image']['name'], null, file_get_contents( $_FILES['image']['tmp_name'] ) );

            //dummy save to user meta
            update_user_meta( 1, 'file_upload_test_data', $_FILES['image']['name'] );

            //send email
            $mail_attachment = array( WP_CONTENT_DIR . '/uploads/2018/02/'.$_FILES['image']['name'].'');   
            $headers = 'From: My Name <myname@mydomain.com>' . "\r\n";

            wp_mail('sanzeeb.aryal@gmail.com', 'file test', 'This is test of attachment', $headers, $mail_attachment);

            echo "File Upload Successful!";    
        }
    }
}
 
add_shortcode( 'file-upload-test','shortcode_function' );

function shortcode_function() {
    ob_start();
    registration_form_view();
    process_data();
    return ob_get_clean();
}
?>