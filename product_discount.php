<?php

/* Calculate specific product discount on cart page woocommerce */


// Hook before calculate woocommerce cart totals
add_action('woocommerce_before_calculate_totals', 'apply_discount_for_specific_product', 10, 1);

function apply_discount_for_specific_product($cart) {
    // Define the specific product ID and the required quantity
    $specific_product_id = 123; // Specific product ID
    $quantity = 3;   // Required quantity to apply the discount
    $discount_percentage = 10; // Discount percentage
     
    // Loop through the cart items
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        // Check if the current item is the target product and the quantity matches
        if ($cart_item['product_id'] == $specific_product_id && $cart_item['quantity'] >= $quantity) {
            // Calculate the new price from sale price if exist else regular price
            $original_price = $cart_item['data']->get_sale_price() ? $cart_item['data']->get_sale_price() : $cart_item['data']->get_regular_price();
            $discounted_price = $original_price * ((100 - $discount_percentage) / 100);
            // Apply the discounted price only to the product
            $cart_item['data']->set_price($discounted_price);
        }
    }
}

