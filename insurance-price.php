<?php
add_action( 'woocommerce_after_checkout_billing_form', 'sb_checkout_radio_choice',30, 1 );
add_action( 'woocommerce_cart_calculate_fees', 'sb_checkout_radio_choice_fee', 20, 1 ); 
add_action( 'woocommerce_checkout_update_order_review', 'sb_checkout_radio_choice_set_session' );

function sb_checkout_radio_choice() {
     
   $chosen = WC()->session->get( 'insurance_amount' );
   $chosen = empty( $chosen ) ? WC()->checkout->get_value( 'insurance_amount' ) : $chosen;
   $chosen = empty( $chosen ) ? '0' : $chosen;
        
   $args = array(
   'type' => 'text',
   'class' => array( 'form-row-wide', 'update_totals_on_change' ),
   'default' => $chosen
   );
     
   echo '<div id="checkout-radio" class="checkout-radio-insurance">';
   echo '<h3>Your storage insurance</h3>';
   echo '<p>Add insurance to your booking for 100% piece of mind</p>';
   echo '<p class="form-row form-row-wide update_totals_on_change" id="radio_choice_field" data-priority=""><span class="woocommerce-input-wrapper"><div class="insure_option_wrapper"><div class="insure_option"><input type="radio" class="input-radio " value="20" name="radio_choice" id="radio_choice_20"><label for="radio_choice_20" class="radio ">Please arrange insurance</label></div><div class="insure_option" ><input type="radio" class="input-radio " value="0" name="radio_choice" id="radio_choice_0" ><label for="radio_choice_0" class="radio ">I will arrange my own insurance</label></div></div></span></p>';
   echo '<div class="insurance_dec">';
   echo '<p>It is a requirement that the sum insured represents the full value of the stored goods. Please declare the full value of the stored goods, please complete this even if you do not require insurance</p>';
   echo '<p>Value of stored goods*</p>';
   echo '<div class="input_insurance_amount_wrap">';
   echo '   <div class="input_insurance">';
               woocommerce_form_field( 'insurance_amount', $args, $chosen );
   echo '   </div>';
   echo '   <div class="input_insurance_dec">Insurance is charged at 0.20% per 4 weeks of the declared value + IPT tax at 12%</div>';
   echo '</div>';
   echo '</div>';
   //echo '<div class="insurance_wrapper"><input type="text" value="" name="insurance_price" id="insurance_price" placeholder="£"></div>';
   echo '</div>';
     
}
  

// Part 2 
// Add Fee and Calculate Total
    
function sb_checkout_radio_choice_fee( $cart ) {
   
   if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
    
   $radio = ( (( (WC()->session->get( 'insurance_amount' ) * 0.20 ) / 100 ) * 12) / 100 ) + ((WC()->session->get( 'insurance_amount' ) * 0.20 ) / 100 );
     
   if ( $radio ) {
      $cart->add_fee( 'Insurance',  $radio );
   }
   
}
  

// Part 3 
// Add Radio Choice to Session
  
function sb_checkout_radio_choice_set_session( $posted_data ) {
    parse_str( $posted_data, $output );
    if ( isset( $output['insurance_amount'] ) ){
        WC()->session->set( 'insurance_amount', $output['insurance_amount'] );
    }
   //  if($output['insurance_amount'] == 0){
   //    WC()->session->set( 'insurance_amount', 0 );
   //  }
}









add_action( 'wp_footer', 'checkout_shipping_packing_script' );
// Php Ajax (Receiving request and saving to WC session)
add_action( 'wp_ajax_woo_get_ajax_data', 'woo_get_ajax_data' );
add_action( 'wp_ajax_nopriv_woo_get_ajax_data', 'woo_get_ajax_data' );

function checkout_shipping_packing_script() {
    // Only checkout page
    if ( is_checkout() && ! is_wc_endpoint_url() ) :

    WC()->session->__unset('insurance_amount');
    ?>
    <script type="text/javascript">
    jQuery( function($){
      jQuery('input[type=radio][name=radio_choice]').change(function() {
            var insurance_amount = $(this).val();
            console.log(insurance_amount);
            $.ajax({
                type: 'POST',
                url: wc_checkout_params.ajax_url,
                data: {
                    'action': 'woo_get_ajax_data',
                    'insurance_amount': insurance_amount,
                },
                success: function (result) {
                    $('body').trigger('update_checkout');
                    console.log('response: '+result); 
                },
                error: function(error){
                    console.log(error); 
                }
            });
        });
    });
    </script>
    <?php
    endif;
}


function woo_get_ajax_data() {
    if ( isset($_POST['insurance_amount']) ){
        $insurance_amount = sanitize_key( $_POST['insurance_amount'] );
        WC()->session->set('insurance_amount', $insurance_amount );
        echo json_encode( $insurance_amount );
    }
    die(); 
}

// Add a custom dynamic packaging fee
add_action( 'woocommerce_cart_calculate_fees', 'add_packaging_fee', 20, 1 );
function add_packaging_fee( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    $domain      = "woocommerce";
    $insurance_amount = WC()->session->get( 'insurance_amount' ); 

   

    if ( isset($insurance_amount) )
        $cart->add_fee( 'Insurance', "" );
}