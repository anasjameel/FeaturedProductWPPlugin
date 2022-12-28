<?php
/*
   Plugin Name: Featured Product
   description: Featured Product shows a single product or category based on product ID or Category ID
   Version: 1.0
   Author: Anas Jameel
   Author URI: https://anajameel.com
   License: GPL2
*/
function featured_product_atts($atts)
{
    $default = array(
        'id' => null,
        'subheading' => null,
    );

    $a = shortcode_atts($default, $atts);
    $product_id = $a['id']; // Set the product ID
    $_product = wc_get_product($product_id); // Get the product
    $price = $_product->get_price_html(); // Display the product title
    $link = get_permalink($_product->get_id());
    $utm = '?utm_source=gearsupply&utm_medium=blog&utm_campaign=Blog+CRO';
    $link = $link.$utm;
     $imgUrl = wp_get_attachment_thumb_url($_product->get_image_id());
            if (empty($imgUrl)) {
              $imgUrl = 'https://gearsupply.com/wp-content/uploads/2021/01/product_placeholder-square.png';
            }

        if(empty($price))
            {
               $price = '';
               $btnText = 'Check Price & Availability';
            }
            else {
              $price = $price.' <span class="fs-available"> on Gearsupply</span>';
              $btnText = 'Buy Now';
            }
    $newDesc = strip_tags($_product->get_description());
    //$newDesc = substr($newDesc, 0, 150);
    if (empty($newDesc))
    {
        $newDesc = '';
    }
    elseif(strlen($newDesc) > 149) 
    {
       $newDesc = '<p class=featured-product-desc>' . substr($newDesc, 0,150) . ' <a class="read-more" href="'.$link.'">... Read More</a></p>';
    }
    else
    {
        $newDesc = '<p class=featured-product-desc>' .$newDesc. '</p>';
    }
    $sub = $a['subheading'];

    if (empty($sub))
    {
        $sub = '';
    }
    else
    {
        $sub = '<h4 class=fp-subheading>' . $sub . '</h4>';
    }
    $htmlProduct = '<div class=featured-product-container>
   <div class=featured-product-image>
    <a href="'.$link.'"><figure><img src=' .$imgUrl. '></figure></a>
  </div>

  <div class=featured-product-metafields>
    <a href="'.$link.'"><h3 class=fp-title>' . $_product->get_name() . '</h3></a>' . $sub . '
        ' . $newDesc . '
    <div class=price-wrapper><span class=featured-product-price>' . $price . '</span></div>
    <div class="fp-btn-wrapper"><a target="_blank" class="buy-btn" href=' .$link. '>'.$btnText.'</a></div>
  </div>
</div>';
    if (isset($a['id']))
    {
        return $htmlProduct;
    }
    else
    {
        return '';
    }
}
add_shortcode('featured_product', 'featured_product_atts');

include('featured-summary.php');

include('featured-scroller.php');



function fp_styles()
{
    wp_enqueue_style('featured-product', plugin_dir_url(__FILE__) . '/css/style.css?v=1.01');
    wp_enqueue_style('featured-product-scroller', plugin_dir_url(__FILE__) . '/css/owl.carousel.min.css');
}

function fp_scripts(){
    wp_enqueue_script('featured-product-scroller', plugin_dir_url(__FILE__) . '/js/owl.carousel.js');
    wp_enqueue_script('featured-product', plugin_dir_url(__FILE__) . '/js/script.js?v=1.0' );
    wp_enqueue_script('featured-product-autoplay', plugin_dir_url(__FILE__) . '/js/owl.autoplay.js?v=1.0' );
    
}



add_action('wp_enqueue_scripts', 'fp_styles');
add_action('wp_enqueue_scripts', 'fp_scripts', 9999);


?>


