<?php
add_filter( 'woocommerce_get_price_html', 'cw_change_product_price_display' );
add_filter( 'woocommerce_cart_item_price', 'cw_change_product_price_display' );
add_filter ('add_to_cart_redirect', 'redirect_to_checkout');
add_filter( 'woocommerce_cart_contents_changed', 'woo_cart_ensure_only_one_item' );
add_filter( 'woocommerce_cart_item_quantity', 'wc_cart_item_quantity', 10, 3 );
add_action('woocommerce_before_checkout_form', 'displays_cart_products_feature_image');
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );
add_filter( 'woocommerce_checkout_fields' , 'default_values_checkout_fields' );
add_action( 'woocommerce_before_calculate_totals', 'custom_cart_items_prices', 10, 1 );
add_action( 'woocommerce_cart_calculate_fees', 'df_add_ticket_surcharge' );
//add_action('woocommerce_review_order_before_payment','add_extra_information');
add_action('woocommerce_checkout_fields','customization_readonly_billing_fields',10,1);

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');
add_action( 'woocommerce_review_order_before_order_total', 'woocommerce_checkout_coupon_form_custom' );

add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
remove_action( 'woocommerce_after_checkout_billing_form', 'woocommerce_checkout_shipping' );
add_action( 'woocommerce_review_order_before_payment', 'woocommerce_checkout_billing_form_custom' );
add_filter( 'woocommerce_thankyou_order_received_text', 'stb_thank_you_text' );


/**
 * Add Extra text with price
 */
function cw_change_product_price_display( $price ) {
    $price .= '<p>Per week (inc VAT)</p>';
    return $price;
}



/**
 * Cart page redirection
 */

function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}


/**
 * Add only one product in cart
 */
function woo_cart_ensure_only_one_item( $cart_contents ) {
    return array( end( $cart_contents ) );
}



/**
 * Hide Quantity option
 */

function wc_cart_item_quantity( $product_quantity, $cart_item_key, $cart_item ){
    if( is_cart() ){
        $product_quantity = sprintf( '%2$s <input type="hidden" name="cart[%1$s][qty]" value="%2$s" />', $cart_item_key, $cart_item['quantity'] );
    }
    return $product_quantity;
}

/**
 * Display cart product details on checkout page
 */
function displays_cart_products_feature_image() {
?>
   <div class="checkout_label_wrap">
        <h3><?php _e('Let’s just confirm the final details','storage'); ?></h3>
   </div>
  <?php  
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $product = $cart_item['data'];
       
        if(!empty($product)){ ?>
            <div class="package-detail-item-sec">
                <div class="package-item-img">
                    <div class="item-img">
                        <?php echo $product->get_image(); ?>
                    </div>
                </div>
                <div  class="package-item-text">
                    <h3 ><?php echo get_field('pod_size',$product->id); ?> - <?php echo $product->name; ?> </h3>
                    <p ><?php echo get_field('pod_short_info',$product->id); ?></p>
                   
                </div>
            </div>
           
       <?php }
    }
}

//Change the 'Billing details' checkout label to 'Contact Information'
function wc_billing_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Billing details' :
            $translated_text = __( 'Your Contact Details', 'woocommerce' );
        break;
    }
    return $translated_text;
    }





function default_values_checkout_fields( $fields ) {
    // You can use this for postcode, address, company, first name, last name and such. 
    $fields['billing']['billing_postcode']['default'] = $_SESSION['postcode'];
    return $fields;
}


function custom_cart_items_prices( $cart ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

       
    foreach ( $cart->get_cart() as $cart_item ) {
       
        $distance       = intval($_SESSION['distance']);

        $product_id = $cart_item['data']->get_id();
        $pod_no              = get_field('pod_no',$product_id);
        $price_for_product   = get_field('price_for_product','option');
        $how_many_miles_set_for_distance_calculation      = get_field('how_many_miles_set_for_distance_calculation','option');
        $per_mile_price                                   = get_field('per_mile_price','option');
        $regular_price = $price_for_product * $pod_no;
        $distance_cal = $distance - $how_many_miles_set_for_distance_calculation;
        $new_mile_price = $distance_cal * $per_mile_price ;
        // $regular_price = ($price_for_product * $pod_no) + $new_mile_price;

        $regular_price = ($distance >= $how_many_miles_set_for_distance_calculation) ? ( ($price_for_product * $pod_no) + $new_mile_price ) : $price_for_product * $pod_no;
      
        $cart_item['data']->set_price( $regular_price ); 
    }
}

function df_add_ticket_surcharge( $cart_object ) {

    global $woocommerce;
    
    foreach ( $cart_object->cart_contents as $key => $value ) {
        
        $distance       = intval($_SESSION['distance']);

        $proid = $value['product_id']; //get the product id from cart
        $quantiy = $value['quantity']; //get quantity from cart
        $itmprice = $value['data']->price; //get product price

        $how_many_miles_set_for_distance_calculation      = get_field('how_many_miles_set_for_distance_calculation','option');
        $collection_price                                 = get_field('collection_price','option');
        $per_mile_price                                   = get_field('per_mile_price','option');
        $pod_no                                           = get_field('pod_no',$proid);
        
        $distance_cal = $distance - $how_many_miles_set_for_distance_calculation;
        $new_mile_price = $distance_cal * $per_mile_price ;

        $c_price = ($distance >= $how_many_miles_set_for_distance_calculation) ? ((($collection_price * $pod_no)+ 128) + $new_mile_price) : ($collection_price * $pod_no) + 128;
        
    
    }

    if($c_price > 0 ) {

        $woocommerce->cart->add_fee( 'Collection Services', $c_price, true, 'standard' );
        
    }

}



function add_extra_information(){
  
    global $woocommerce,$product;
     //echo '<pre>';  print_r(WC->cart->get_cart());
     

        $pod_no               = get_field('pod_no',$product_id);
        $after_3_month_price  = get_field('after_3_month_price','option');
        echo $after_3_month_price;
        $after_three_month    = $after_3_month_price * $pod_no;
        echo '<tr><p>£'.$after_three_month.' per month after 3 months</p></tr>';
    
       
}


function customization_readonly_billing_fields($checkout_fields){
   
    foreach ( $checkout_fields['billing'] as $key => $field ){
        if($key == 'billing_postcode'){
            
         
                $checkout_fields['billing'][$key]['custom_attributes'] = array('readonly'=>'readonly');
          
        }
    }
    return $checkout_fields;
}



function woocommerce_checkout_coupon_form_custom() {
    echo '<tr class="coupon-form"><td colspan="2">';
    
    wc_get_template(
        'checkout/form-coupon.php',
        array(
            'checkout' => WC()->checkout(),
        )
    );
    echo '</tr></td>';
}


function woocommerce_checkout_billing_form_custom() {
    echo '<tr class="coupon-form"><td colspan="2">';
    
    wc_get_template(
        'checkout/form-shipping.php',
        array(
            'checkout' => WC()->checkout(),
        )
    );
    echo '</tr></td>';
}




function stb_thank_you_text ( $thank_you_msg ) {

    $thank_you_msg =  'Thank you for your order. Our team will be in touch to confirm your booking and arrange collection.';

return $thank_you_msg;
}