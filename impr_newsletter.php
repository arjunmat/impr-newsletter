<?php
/**
 * Plugin Name: Improvi Newsletter Signup
 * Plugin URI: http://improvi.in/wordpress/plugins/newsletter
 * Description: Allow users to signup for a newsletter which is stored in a database table.
 * Version: 1.0
 * Author: Arjun Mathai
 * Author URI: http://improvi.in/blog/users/arjun
 * License: GPL2
 */

/*  Copyright 2014  Arjun Mathai  (email : arjun@improvi.in)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require( plugin_dir_path( __FILE__ ) . '/install.php');
require( plugin_dir_path( __FILE__ ) . '/admin.php');
//register_activation_hook( __FILE__, 'impr_nl_install_plugin' );

if( is_admin() ) $my_settings_page = new NewsletterSettingsPage();

add_action( 'wp_enqueue_scripts', 'impr_nl_enqueue_scripts' );
add_action( 'wp_enqueue_styles', 'impr_nl_enqueue_styles' );

add_shortcode('impr_newsletter', 'impr_nl_shortcode_fn');

add_action( 'wp_ajax_impr_nl_signup', 'impr_nl_signup' );
add_action( 'wp_ajax_nopriv_impr_nl_signup', 'impr_nl_signup' );

add_action('wp_head','impr_nl_ajaxurl');

function impr_nl_ajaxurl() {
	echo "
		<script type='text/javascript'>
			var impr_nl_ajaxurl = '". admin_url('admin-ajax.php'). "';
		</script>
	";
}

/* Shortcode function */
function impr_nl_shortcode_fn($attributes) {
	// get optional attributes and assign default values if not present
    extract( shortcode_atts( array(
        'text' => '',
        'class' => '',
		'placeholder' => 'Email Address',
		'btn_text'	=> 'Register'
    ), $attributes ) );
    
	$nlCode = impr_nl_display($text, $class, $placeholder, $btn_text);
    if( $nlCode ) return $nlCode;
}

/* Display the plugin code */
function impr_nl_display($text, $class, $placeholder, $btnText) {
	echo "
		<div class='impr_newsletter $class'>
			<div class='impr_text'>$text</div>
			<span class='impr_request_box'>
				<input type='text' class='impr_nl_input' placeholder='$placeholder'  />
				<button type='submit' class='impr_nl_btn'>$btnText</button>
			</span>
			<div class='impr_error'></div>
		</div>";
}

/* Plugin Styles */
function impr_nl_enqueue_styles() {
	wp_register_style( 'impr_nl_style', plugins_url( 'css/impr_nl.css' , __FILE__ ));
	wp_enqueue_style('impr_nl_style');
}

/* Plugin Scripts */
function impr_nl_enqueue_scripts() {
	wp_register_script( 'impr_nl_js', plugins_url('js/impr_nl.js', __FILE__ ), array( 'jquery' ), true);
	wp_enqueue_script('impr_nl_js');
}

function impr_nl_signup() {
	global $wpdb; // this is how you get access to the database

	$email = $_POST['email'];
	
	if($email !== '')
	{
		$fp = fopen (plugin_dir_path( __FILE__ ) . 'impr_newsletters.csv', "a");
		
		fwrite($fp, PHP_EOL . date('Y-m-d H:i:s') . "," .$email);
		
		fclose($fp);
	
		echo json_encode("success");
	}
	else
		echo json_encode("fail");
	
	die();
}
