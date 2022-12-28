<?php /* Shortcode for Product Summary Block */

function featured_summary_atts($atts)
{
    $default = array(
        'id' => null
    );
    $a = shortcode_atts($default, $atts);
    $id = $a['id'];
    $no_whitespaces = preg_replace('/\s*,\s*/', ',', filter_var($id, FILTER_SANITIZE_STRING));
    $product_id_array = explode(',', $no_whitespaces);
    $output .= '<div class=featured-summary-container>';  
    foreach ($product_id_array as $k => $product_id)
    {
        $_product1 = wc_get_product($product_id);
        if (isset($_product1))
        {
            $product_name = $_product1->get_name();
            $newDesc1 = strip_tags($_product1->get_description());
            $link = get_permalink($_product1->get_id());
            $utm = '?utm_source=gearsupply&utm_medium=blog&utm_campaign=Blog+CRO';
            $link = $link.$utm;
            $imgUrl = wp_get_attachment_thumb_url($_product1->get_image_id());
            if (empty($imgUrl)) {
              $imgUrl = 'https://gearsupply.com/wp-content/uploads/2021/01/product_placeholder-square.png';
            }

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
            $price1 = $_product1->get_price_html();
            if(empty($price1))
            {
               $price1 = 'Check Availability';
            }
            else {
              $price1 = $price1.' on Gearsupply';
            }
            $output .= '<div class=featured-summary-item>
              <div class=fs-image>
                  <a href="'.$link.'"><figure><img src=' . $imgUrl . '></figure></a>
              </div>
              <div class=fs-details>
                  <a href="'.$link.'"><h4 class=fs-title>' . $product_name . '</h4></a>
                  ' . $newDesc1 . '
                  <a class="check-price mob-only" href=' .$link.'>'.$price1.'</a>
              </div>
              <div class=fs-button>
                  <a class="check-price" href=' .$link.'>'.$price1.'</a>
              </div>
          </div>';
        }
        else
        {
            $output .= '';
        }
    }
    $output .= '</div>';
    return $output;
}
add_shortcode('featured_summary', 'featured_summary_atts');
?>
