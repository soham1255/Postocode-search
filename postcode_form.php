<div class="stb_postcode_form_wrap">
    <form class="stb_postcode_form" action="" id="stb_postcode_form" method="post">
        <div class="wrapper"><h5 class="form__title"><?php  _e("What's your location?"); ?></h5> 
            <div class="form__field">
                <input autocomplete="off" name="postcode" type="text" placeholder="Enter full postcode" id="postcode_input" class="form__input postcode_input" aria-required="true" aria-invalid="false" style="text-transform: uppercase;" value="">
            </div>
            <div class="form__field"> 
                <button class="btn btn--alternate postcode_submit"><?php _e('Continue'); ?></button>
                <input type="hidden" value="<?php echo site_url('/pod-storage'); ?>" name="success_page" class="success_page">
                <div class="loader-6">
                    <span></span><span></span><span></span><span></span><span></span>
                </div> 
            </div>
        </div>
        
    </form>
    
</div>
    