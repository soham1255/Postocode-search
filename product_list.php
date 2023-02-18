<section class="gs__slider-section">
<div class="container">
    <div class="gs__slider-inner">
        <div class="swiper gs__slider-silder">
            <div class="swiper-wrapper">
        <?php    $args = array( 
                'post_type' => 'product', 
                'posts_per_page' => -1,
                'order' => 'ASC',
            );
                    
        $loop = new WP_Query( $args ); 
        $i=1;
        $product_array = array();
        if ( $loop->have_posts() ): 
            while ( $loop->have_posts() ): $loop->the_post();
            global $product;
            $product_array[]  = $product->id;
          
            $postcode       = $_SESSION['postcode'];
            $distance       = intval($_SESSION['distance']);
            $pod_no         = get_field('pod_no',$product->id);
            $pod_size       = get_field('pod_size',$product->id);
            $pod_room       = get_field('pod',$product->id);
            $pod_short_info = get_field('pod_short_info',$product->id);
            $pod_video      = get_field('pod_video',$product->id,false,false);
            $pod_image      = get_field('pod_image',$product->id);

          
           
            $how_many_miles_set_for_distance_calculation      = get_field('how_many_miles_set_for_distance_calculation','option');
            $price_for_product                                = get_field('price_for_product','option');
            $collection_price                                 = get_field('collection_price','option');
            $per_mile_price                                   = get_field('per_mile_price','option');
            $after_3_month_price                              = get_field('after_3_month_price','option');

          
                $distance_cal = $distance - $how_many_miles_set_for_distance_calculation;
                $new_mile_price = $distance_cal * $per_mile_price ;

                $regular_price = ($distance >= $how_many_miles_set_for_distance_calculation) ? ($price_for_product * $pod_no) + $new_mile_price : $price_for_product * $pod_no;
                $after_three_month = ($distance >= $how_many_miles_set_for_distance_calculation) ? ($after_3_month_price * $pod_no) + $new_mile_price : $after_3_month_price * $pod_no;

                // if($distance >= $how_many_miles_set_for_distance_calculation){
                   
                    
                //     $regular_price     = ($price_for_product * $pod_no) + $new_mile_price;
                //     $after_three_month = ($after_3_month_price * $pod_no) + $new_mile_price;
                // }else{
                //     $regular_price     = $price_for_product * $pod_no;
                //     $after_three_month = $after_3_month_price * $pod_no;
                // }
               
                product_content($i,$product,$pod_size,$pod_room,$pod_image,$vid,$pod_short_info,$postcode,$regular_price,$after_three_month,$distance);
              

          $i++;  endwhile; endif; ?>
            
            
            </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
</section>

<?php

function product_content($i,$product,$pod_size,$pod_room,$pod_image,$vid,$pod_short_info,$postcode,$regular_price,$after_three_month,$distance){ ?>

    <div class="swiper-slide">
        <div class="gs__slider-block">
            <div class="banner-offer">
                <h2><?php  _e('50% off Storage'); //echo $distance; ?></h2>
                <span><?php _e('Your First 12 weeks'); ?></span>
            </div>
            <div class="slider-content">
                <h4><?php the_title(); ?></h4>
                <h3><?php echo $pod_size ?></h3>
              
                <div class="package-image"> 
                    <img src="<?php echo $pod_image['url'];?>" alt="package">
                        <!-- <a class="popup-youtube" href="https://www.youtube.com/watch?v=<?php echo $vid;?>"> 
                            <img src="<?php echo site_url()?>/wp-content/uploads/2022/12/video_icon.png" alt="video_icon">
                        </a> -->
                </div>
                <div class="gs__price">
                <!-- <h3 class="strikethrough"><?php echo get_woocommerce_currency_symbol(); ?><?php echo $regular_price; ?></h3> -->
                <h3><?php echo get_woocommerce_currency_symbol(); ?><?php echo $regular_price;?></h3>
                </div>
                <div class="gs_discount-block">
                <p><?php _e('Per 4 weeks (inc VAT)'); ?></p>
                <p><?php _e('After first 12 weeks'); ?></p>
                <strong><?php echo get_woocommerce_currency_symbol(); ?><?php echo $after_three_month;?></strong><span><?php _e('(per 4 weeks)'); ?></span>
                </div>
                <?php echo $pod_short_info; ?>
                
                <div class="gs__book-btn  pod_<?php echo $i; ?>"> <a data-id="<?php echo $i; ?>" href="<?php echo site_url(); ?>/?add-to-cart=<?php echo $product->id; ?>" ><?php _e('Select'); ?></a></div>
            </div>
        </div>
    </div>
<?php

}