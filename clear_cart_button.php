<?php

/* Adding ajax clear cart button on child theme function.php */

add_action('woocommerce_before_cart_table', 'clear_cart_button');

function clear_cart_button()
{
?>
    <button class="button" id="clear_cart_button">Clear Cart</button>

    <script>
        jQuery(function($) {
            $('#clear_cart_button').on('click', function(e) {
                e.preventDefault();
                // confirmation alert before clear
                if (confirm('Are you sure you want to remove all items from your cart?')) {
                    $.ajax({
                        type: 'POST',
                        url: wc_cart_fragments_params.ajax_url,
                        data: {
                            action: 'clear_cart_action'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Load the empty cart content
                                $('.woocommerce').replaceWith('<div class="woocommerce woocommerce-cart-empty-page"><div class="woocommerce-message" role="alert"><?php _e("Your cart is successfully cleared.", "woocommerce"); ?></div><p class="return-to-shop"><a class="button wc-backward" href="<?php echo esc_url(wc_get_page_permalink("shop")); ?>"><?php _e("Return to shop", "woocommerce"); ?></a></p></div>');
                                // WooCommerce's cart refresh
                                jQuery(document.body).trigger('wc_fragment_refresh');
                            }
                        }
                    });
                }
            });
        });
    </script>
<?php
}

// clear cart callback
function clear_cart_action_callback()
{
    // Clear the cart
    WC()->cart->empty_cart();
    // Send a success response
    wp_send_json_success();

    // End the function
    die();
}
add_action('wp_ajax_clear_cart_action', 'clear_cart_action_callback');
add_action('wp_ajax_nopriv_clear_cart_action', 'clear_cart_action_callback');
