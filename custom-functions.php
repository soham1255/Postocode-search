<?php 

add_action('wp_head', 'myplugin_ajaxurl');
add_shortcode('postcode_form','postcode_form');
add_action('wp_ajax_postcode_ajax', 'postcode_ajax' ); 
add_action('wp_ajax_nopriv_postcode_ajax', 'postcode_ajax' ); 
add_shortcode('product_list','product_list');
add_action('acf/init', 'my_acf_op_init');

function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Theme General Settings'),
            'menu_title'    => __('Theme Settings'),
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}

function postcode_price_front_data(){

    global $wpdb;
    $table_postcode_meta = $wpdb->prefix."postcode_meta";
    $table_postcode = $wpdb->prefix."postcode";

    $postcode_meta = $wpdb->get_results( "SELECT * FROM $table_postcode_meta");
    $postcode = $wpdb->get_results( "SELECT * FROM $table_postcode");

    $data = array( 
        'postcode' => $postcode,
        'postcode_meta' => $postcode_meta
    );

    return $data;
}

function postcode_data_validation_frontend( $data )
{
    
    $product_id        = get_the_ID();
    $postcode_id       = $data->id;
    $postcode          = $data->postcode;
    $price             = $data->price;
    $sale_price        = $data->sale_price;
    $collection_price  = $data->collection_price;

    $data_varifications = postcode_price_front_data();
    
    foreach ( $data_varifications['postcode_meta'] as $key => $value ) {
        if( ( $value->product_id == $product_id ) && ( $value->postcode == $postcode ) )
        return $value;
    }
    return $data;

}



function myplugin_ajaxurl() {

echo '<script type="text/javascript">
var ajaxurl = "' . admin_url('admin-ajax.php') . '";
var ajax_nonce = "'.wp_create_nonce( "secure_nonce_name" ).'";
</script>';
}



/**
 * Postcode Form
 */
function postcode_form(){
    ob_start();
     
    
    include_once ('postcode_form.php');

  
    $html = ob_get_contents();
            
    ob_end_clean();

    return $html;
}



/**
 * Ajax Postcode Form Submit Data
 */

 function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}


function postcode_ajax(){
    
    $postcode_input = $_POST['postcode_input'];
    
    $input_files = array('Aylesbury.csv', 'Crawley.csv', 'Edinburgh.csv', 'Ely.csv', 'Exeter.csv', 'Guildford.csv', 'Portsmouth.csv', 'Thurrock.csv', 'York.csv','Brandon.csv','PottersBar.csv'); // files to merge
    $base_postcodes = array('HP19 8UN', 'RH10 9SP', 'EH26 8EZ', 'CB6 3NW', 'EX5 1EW', 'GU1 1SZ', 'PO3 5GF', 'RM19 1NA', 'LS25 6ES','IP27 0NZ','EN6 3JN'); 
    $result = array(); 
    $start_row = 1; //define start row
    $i = 1; //define row count flag
   
    $client = $postcode_input;
    $tkey='';
    $file_name='';
    if(in_array($client,$base_postcodes,TRUE)){
       // echo $client;
        $distance = 0;
        $tkey = 0;
    }else{
        foreach($input_files as $file1){
            $reader = fopen(get_stylesheet_directory(). '/csv/'.$file1, 'r');
            $reader2 = file(get_stylesheet_directory(). '/csv/'.$file1);

            // echo '<pre>'; print_r($reader);
            // die();

            foreach ($reader2 as $key => $value) {
                $temp = explode(',', $value);
        
                if ($temp[3] == $client) {
                
                $tkey = $key;
                $file_name = $file1;
                break;
                
                }
            }
        }
        
       
       
        if($tkey){
            $tkey = $tkey+1;
            $read = fopen(get_stylesheet_directory(). '/csv/'.$file_name, 'r');
            while (($row = fgetcsv($read)) !== FALSE) {
                
                if($i == $tkey) {
                    $basep = $row[0];
                    $baselat = $row[1];
                    $baselong = $row[2];
                    $lat = $row[4];
                    $long = $row[5];
                    
                    
                }
                $i++;
            }
          
            $distance = distance($baselat, $baselong, $lat, $long, "M");
        }else{
         
            $error['postcode_error'] = "For service in your area please call 0800 107 8422";
        }

   
        fclose($reader);
        
            if(empty($postcode_input)){
                $error['postcode_input'] = "Please enter postcode";
            }
    }
        

    if ($error) {
       
		$error['msg'] = "error";
		echo json_encode($error);
	} else {

        $success['msg'] = "Correct postcode";
        $_SESSION['postcode'] = $postcode_input;
        $_SESSION['distance'] = $distance;
		echo json_encode($success);
       
		
	}
    die();
}





/**
 * Product list Shortcode
 */
function product_list(){
    ob_start();
        
        include_once ('product_list.php');

    $html = ob_get_contents();
            
    ob_end_clean();

    return $html;
}





