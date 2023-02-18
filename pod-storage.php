<?php 
/*
Template Name: Pod Storage
*/
get_header();

if( $_SESSION['postcode']){ 

   $mfn_builder = new Mfn_Builder_Front(get_the_ID());
						$mfn_builder->show();

 }else{

    wp_redirect( '/booking' );

}



get_footer();
?>