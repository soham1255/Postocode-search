<?php
add_action( 'woocommerce_after_checkout_billing_form', 'popup_quote',  40, 1);
add_action('wp_ajax_email_quote_ajax', 'email_quote_ajax' ); 
add_action('wp_ajax_nopriv_email_quote_ajax', 'email_quote_ajax' ); 


/**
 * Email Quote button added after checkout form
 */
function popup_quote(){ ?>

<div class="bottom-booknow-row d-flex es_email_quote_wrap">
        <a class="booking-edit-btn" href="<?php echo site_url()?>/pod-storage"><?php _e('< Back','storage'); ?></a>
        <div class="quote-email">
            <a class="send-quote-link" href="javascript:void(0);"><?php _e('Email me this quote','storage'); ?></a>
        </div>
    </div>

<?php }


/**
 * Popup form
 */
function email_quote_popup(){ ?>

    <div class="email-modal" >
        <div class="email_contact_wrap">
            <span class="close">X</span>
            <div class="top-heading-email-box">
                <h2><?php _e('Get this quote'); ?></h2>
                <p><?php _e('Receive your personalised quote by email. By obtaining a quote, you agree that Ease the Squeeze Storage will contact you to fulfil your storage requirements.'); ?></p>
            </div>
            <div class="email_form_wrap">
                <form id="quote_form" method="POST" action="">
                    <div class="q_form_field_wrap">
                        <div class="q_form_field">
                            <input type="email" name="q_email" class="q_email" id="q_email" value="">
                        </div>
                        <div class="q_form_field">
                            <input type="submit" name="q_email_submit" class="q_email_submit" id="q_email_submit" value="Send me this quote" >
                            <div class="loader-6">
                                <span></span><span></span><span></span><span></span><span></span>
                            </div> 
                        </div>
                    </div>
                </form>   
                <div class="q_success_msg" style="color:green"></div>
                <div class="q_error_msg" style="color:red;"></div>
            </div>   
        </div>
    </div>

<?php }



function email_quote_ajax(){

    $q_email = $_POST['q_email'];

    if(empty($q_email)){
        $error['error_email'] = "Please enter email address";
    } 
    
     // Loop over $cart items
     foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

       
        $currency = get_woocommerce_currency_symbol();
        $product = $cart_item['data'];
        $product_id = $cart_item['product_id'];
        $variation_id = $cart_item['variation_id'];
        $quantity = $cart_item['quantity'];
        $price = WC()->cart->get_product_price( $product );
        //$price = WC()->cart->$c_price;
        $subtotal = WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] );
        $total = WC()->cart->get_total();
        $link = $product->get_permalink( $cart_item );
        // Anything related to $product, check $product tutorial
        $attributes = $product->get_attributes();
        $whatever_attribute = $product->get_attribute( 'whatever' );
        $whatever_attribute_tax = $product->get_attribute( 'pa_whatever' );
        $any_attribute = $cart_item['variation']['attribute_whatever'];
        $meta = wc_get_formatted_cart_item_data( $cart_item );

        $distance       = intval($_SESSION['distance']);
        $pod_no              = get_field('pod_no',$product_id);
        $pod_size            = get_field('pod_size',$product->id);
        $pod_image           = get_field('pod_image',$product->id);
        $pod_short_info      = get_field('pod_short_info',$product->id);
        $price_for_product   = get_field('price_for_product','option');
        $how_many_miles_set_for_distance_calculation      = get_field('how_many_miles_set_for_distance_calculation','option');
        $per_mile_price                                   = get_field('per_mile_price','option');
        $regular_price = $price_for_product * $pod_no;
        $distance_cal = $distance - $how_many_miles_set_for_distance_calculation;
        $new_mile_price = $distance_cal * $per_mile_price ;

        $how_many_miles_set_for_distance_calculation      = get_field('how_many_miles_set_for_distance_calculation','option');
        $collection_price                                 = get_field('collection_price','option');
        $per_mile_price                                   = get_field('per_mile_price','option');
        $after_3_month_price                              = get_field('after_3_month_price','option');

        $distance_cal_c = $distance - $how_many_miles_set_for_distance_calculation;
        $new_mile_price_c = $distance_cal_c * $per_mile_price ;

        $after_three_month = ($distance >= $how_many_miles_set_for_distance_calculation) ? ($after_3_month_price * $pod_no) + $new_mile_price : $after_3_month_price * $pod_no;

        $c_price = ($distance >= $how_many_miles_set_for_distance_calculation) ? (($collection_price * $pod_no) + $new_mile_price_c) : $collection_price * $pod_no;

        $regular_price = ($distance >= $how_many_miles_set_for_distance_calculation) ? ( ($price_for_product * $pod_no) + $new_mile_price ) : $price_for_product * $pod_no;

        
    }
   $insurance_fee = ( (( (WC()->session->get( 'insurance_amount' ) * 0.20 ) / 100 ) * 12) / 100 ) + ((WC()->session->get( 'insurance_amount' ) * 0.20 ) / 100 );
  
    $header_logo              = get_field('email_header_logo','option');
    $email_contant            = get_field('email_contant','option');
    $email_footer_content     = get_field('email_footer_content','option');
    $email_footer             = get_field('email_footer','option');
    $email_address            = get_field('email_','option');
    $email_footer_last_column = get_field('email_footer_last_column','option');
    $email_footer_logo        = get_field('email_footer_logo','option');
    $site_link                = site_url();
    $product_short_description                = get_field('product_short_description','option');

    if ($error) {
       
		$error['msg'] = "error";
		echo json_encode($error);
	}else{

        $subject = 'Quotation Information';
        $headers = "Content-Type: text/html; charset=UTF-8\r\n";
        $message  = email_content($product,$product_id,$pod_size,$pod_image,$pod_short_info,$currency,$c_price,$regular_price, $total,$after_3_month_price, $site_link,$header_logo,$email_contant,$email_footer_content,$email_footer,$email_address,$email_footer_last_column,$email_footer_logo,$insurance_fee,$product_short_description);


        wp_mail($q_email,$subject,$message, $headers);

        //$success['msg'] = "Send Quotation";
        $success['success'] = "Mail send successfully";
        echo json_encode($success);

    }
   

   

    die();
}