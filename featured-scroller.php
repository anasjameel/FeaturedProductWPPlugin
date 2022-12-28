<?php
/* Returns a carousel with list of products with same category. It takes category slug as an input */


function featured_scroller_atts($atts) {
 	$default = array(
        'cat-slug' => null
    );
    $a = shortcode_atts($default, $atts);
    $slug = $a['cat-slug'];
    $product_args = array(
        'post_status' => 'publish',
        'limit' => -1,
        'category' => $slug
    );
    $products = wc_get_products($product_args); ?>
    <div class="owl-carousel" id="featured-product-scroller">
    <?php
	$index = 1;
    foreach ($products as $product) :
    	
    	$product_id = $product->get_id();
	    $product_type = $product->get_type();
	    $product_title = $product->get_title();
	    $product_permalink = $product->get_permalink();
        $utm = '?utm_source=gearsupply&utm_medium=blog&utm_campaign=Blog+CRO';
        $link = $product_permalink.$utm;
        $newDesc1 = strip_tags($product->get_description());
        if (empty($newDesc1))
              {
                $newDesc1 = '';
              }
            elseif(strlen($newDesc1) > 149) 
              {
                $newDesc1 = '<p class=fs-desc>' . substr($newDesc1, 0,150) . ' <a class="read-more" href="'.$link.'">... Read More</a></p>';
              }
            else
              {
                $newDesc1 = '<p class=fs-desc>' .$newDesc1. '</p>';
           }
	    $price1 = $product->get_price_html();
            if(empty($price1))
            {
               $price1 = 'Check Availability';
            }
            else {
              $price1 = $price1.' on Gearsupply';
            }     
		$product_main_image_id = $product->get_image_id();
		if ($product_main_image_id) :
	        $product_main_image = wp_get_attachment_image_src($product_main_image_id, 'full');
	        $product_main_image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', TRUE);
	    endif;
?>
    <div id="slider-item-<?php echo $index;?>" class="item">
        <a href="<?php echo $link ?>">
            <?php if ($product_main_image) : ?>
                <img src="<?php echo $product_main_image[0]; ?>" alt="<?php echo $product_main_image_alt ?>">
            <?php endif; ?>
        </a>
        <a href="<?php echo $link ?>">
        	<h2 class="scroller-product-title"><?php echo $product_title ?></h2>
        </a>
          <div class="fs-button fs-btn-scroller">
                  <a class="check-price" href="<?php echo $link ?>"><?php echo $price1 ?></a>
              </div>
 
            <?php  echo $newDesc1 ?>
            <!-- display more product infos -->
        
    </div>

<?php $index++;	
	endforeach; 
?>
</div>
<?php
   
}


add_shortcode('featured_scroller', 'featured_scroller_atts');
?>