<?php
/* Returns a carousel with list of products with same category. It takes category slug as an input */


function featured_scroller_atts($atts) {
  $default = array(
        'cat-slug' => ""
    );
    $a = shortcode_atts($default, $atts);
    $slug = $a['cat-slug'];
    $product_args = array(
        'post_status' => 'publish',
        'limit' => 10,
        'category' => $slug
    );
    $products = wc_get_products($product_args); 
    $index = 1;
    $sliderItems = "";
    foreach ($products as $product) :
      
      $product_id = $product->get_id();
      $product_type = $product->get_type();
      $product_title = $product->get_title();
      $product_permalink = $product->get_permalink();
      $imgUrl = wp_get_attachment_thumb_url($product->get_image_id());
            if (empty($imgUrl)) {
              $imgUrl = 'https://gearsupply.com/wp-content/uploads/2021/01/product_placeholder-square.png';
            }
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

  $sliderItems = $sliderItems."<div class='slider-item-".$index." item'>
        <a href=".$link."><img src=".$imgUrl." alt=".$product_main_image_alt."></a>
        <a href=".$link."><h3 class='scroller-product-title'>".$product_title."</h3></a>
        <div class='fs-button fs-btn-scroller'><a class='check-price' href=".$link.">".$price1."</a></div>".$newDesc1."
        </div>";

 
    $index++; 
  endforeach; 

$output = "<div class='owl-carousel' id='featured-product-scroller'>".$sliderItems."</div>";


return $output;
   
}


add_shortcode('featured_scroller', 'featured_scroller_atts');
?>