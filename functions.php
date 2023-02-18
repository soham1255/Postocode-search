<?php
session_start();
global $_SESSION;

/**
 * Betheme Child Theme
 *
 * @package Betheme Child Theme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
 * Child Theme constants
 * You can change below constants
 */

/**
 * Load Textdomain
 * @deprecated please use BeCustom plugin instead
 */

// define('WHITE_LABEL', false);

/**
 * Load Textdomain
 */

load_child_theme_textdomain('betheme', get_stylesheet_directory() . '/languages');
load_child_theme_textdomain('mfn-opts', get_stylesheet_directory() . '/languages');

/**
 * Enqueue Styles
 */

function mfnch_enqueue_styles()
{
	// enqueue the parent stylesheet
	// however we do not need this if it is empty
	// wp_enqueue_style('parent-style', get_template_directory_uri() .'/style.css');

	// enqueue the parent RTL stylesheet

	if ( is_rtl() ) {
		wp_enqueue_style('mfn-rtl', get_template_directory_uri() . '/rtl.css');
	}

	// enqueue the child stylesheet

	wp_dequeue_style('style');
	wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css');
	wp_enqueue_style('custom-css', get_stylesheet_directory_uri() .'/assets/css/custom.css');
	if(is_page('pod-storage')){
		wp_enqueue_style('swiper-css', get_stylesheet_directory_uri() .'/assets/css/swiper-bundle.min.css');
		wp_enqueue_script( 'swiper-js', get_stylesheet_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), time(), true);
		wp_enqueue_script( 'magnific-js', get_stylesheet_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), time(), true);
	}
	
	wp_enqueue_script( 'cst-js', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), time(), true);

	if(is_checkout()){
		wp_enqueue_script( 'checkout-js', get_stylesheet_directory_uri() . '/assets/js/checkout-popup.js', array('jquery'), time(), true);
		wp_enqueue_script( 'checkout-field-js', get_stylesheet_directory_uri() . '/assets/js/checkout-price.js', array('jquery'), time(), true);
	}
	
}
add_action('wp_enqueue_scripts', 'mfnch_enqueue_styles', 101);



add_action( 'wp_enqueue_scripts', 'load_ion_icons' );
function load_ion_icons() {
	wp_enqueue_style( 'ionicons', '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', array(), '1.0' );

}

/**
 * Include custom function file
 */
include 'custom-functions.php';
include 'acf-functions.php';
include 'woocommerce-functions.php';
include 'email-quotation.php';
include 'email-content.php';
include 'insurance-price.php';




function cf7_footer_script(){ ?>
  
	<script>
	document.addEventListener( 'wpcf7mailsent', function( event ) {
		location = 'https://storageaylesbury.com/thank-you/';
	}, false );
	</script>
	  
<?php } 
	  
add_action('wp_footer', 'cf7_footer_script'); 


// Function to change email address
function wpb_sender_email( $original_email_address ) {
    return 'heather.darby@agm.group';
}
 
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
    return 'Ease The Squeeze Storage';
}
 
// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

