<?php

// Menus theme support
add_theme_support('menus');

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

function bellashop_add_to_cart_script()
{
    wp_dequeue_script('wc-add-to-cart');
    // wp_dequeue_script('wc-cart-fragments');
    wp_register_script('bellashop-add-to-cart', get_stylesheet_directory_uri().'/assets/js/frontend/add-to-cart.js', $deps = array('jquery'), $version = 100, $in_footer = true);
    $params = array(
        'ajax_url' => WC()->ajax_url(),
        'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
        'i18n_view_cart' => esc_attr__('View cart', 'woocommerce'),
        'cart_url' => apply_filters('woocommerce_add_to_cart_redirect', wc_get_cart_url()),
        'is_cart' => is_cart(),
        'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add'),
    );
    wp_localize_script('bellashop-add-to-cart', 'wc_add_to_cart_params', $params);
    wp_enqueue_script('bellashop-add-to-cart');
}
add_action('wp_enqueue_scripts', 'bellashop_add_to_cart_script', 200);

// Register menu locaitons
register_nav_menus(array(
    'primary' => __('Primary Menu'),
));

require get_template_directory().'/inc/bellashop_nav_menu_walker.php';

////////////////////////////////////////////////////////////////////////
// Products loop customization
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

function bellashop_template_loop_product_link_open()
{
    global $product;

    $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

    echo '<a class="product-thumb" href="'.esc_url($link).'">';
}
add_action('woocommerce_before_shop_loop_item', 'bellashop_template_loop_product_link_open', 10);

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_after_shop_loop_item', 10);

// Product thumbnails
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

function bellashop_template_loop_product_thumbnail()
{
    global $loop;
    global $product;
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($loop->post->ID), 'single-post-thumbnail');
    echo "<img src=$image[0] alt=\"Product\">";
    // close the <a> tag - see: bellashop_template_loop_product_link_open
    echo '</a>';
}
add_action('woocommerce_before_shop_loop_item_title', 'bellashop_template_loop_product_thumbnail', 10);

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 40);

// Product Sale
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

// Product title
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
function bellashop_template_loop_product_title()
{
    // original class: woocommerce-loop-product__title
    echo '<h3 class="product-title">'.get_the_title().'</h3>';
}
add_action('woocommerce_shop_loop_item_title', 'bellashop_template_loop_product_title', 10);
// Products loop customization
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// Header cart customization

if (!function_exists('bellashop_is_woocommerce_activated')) {
    /**
     * Query WooCommerce activation.
     */
    function bellashop_is_woocommerce_activated()
    {
        return class_exists('WooCommerce') ? true : false;
    }
}

if (!function_exists('bellashop_header_cart')) {
    /**
     * Display Header Cart.
     *
     * @since  1.0.0
     *
     * @uses  \bellashop_is_woocommerce_activated() check if WooCommerce is activated
     */
    function bellashop_header_cart()
    {
        if (bellashop_is_woocommerce_activated()) {
            if (is_cart()) {
                $class = 'current-menu-item';
            } else {
                $class = '';
            } ?>
        <div class="cart">
            <?php bellashop_cart_link(); ?>
            <?php bellashop_cart_dropdown(); ?>
            </div>
        </div>
		<?php
        }
    }
}

add_action('bellashop_header_mini_cart', 'bellashop_header_cart');

if (!function_exists('bellashop_cart_link')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total.
     *
     * @since  1.0.0
     */
    function bellashop_cart_link()
    {
        // echo '<div class="cart-contents">';
        echo '<a href="#"></a>';
        echo '<i class="icon-bag"></i>';
        // echo '<span class="count">'.WC()->cart->get_cart_contents_count().'</span>';
        bellashop_cart_items_count();
        // echo '<span class="subtotal">'.WC()->cart->get_cart_subtotal().'</span>';
        bellashop_cart_subtotal();
        // echo '</div>';
    }
}

function bellashop_cart_items_count()
{
    echo '<span class="count">'.WC()->cart->get_cart_contents_count().'</span>';
}

function bellashop_cart_subtotal()
{
    echo '<span class="subtotal">'.WC()->cart->get_cart_subtotal().'</span>';
}

if (!function_exists('bellashop_cart_dropdown')) {
    function bellashop_cart_dropdown()
    {
        wc_get_template('cart/mini-cart.php');
        // echo '<h1>TEST</h1>';
    }
}

if (!function_exists('bellashop_cart_link_fragment')) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX.
     *
     * @param array $fragments fragments to refresh via AJAX
     *
     * @return array Fragments to refresh via AJAX
     */
    function bellashop_cart_link_fragment($fragments)
    {
        global $woocommerce;

        // ob_start();
        // bellashop_cart_items_count();
        // $fragments['span.count'] = ob_get_clean();

        // ob_start();
        // bellashop_cart_subtotal();
        // $fragments['span.subtotal'] = ob_get_clean();

        ob_start();
        bellashop_header_cart();
        $fragments['div.cart'] = ob_get_clean();

        return $fragments;
    }
}

/*
 * Cart fragment
 *
 * @see storefront_cart_link_fragment()
 */
if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.3', '>=')) {
    add_filter('woocommerce_add_to_cart_fragments', 'bellashop_cart_link_fragment');
} else {
    add_filter('add_to_cart_fragments', 'bellashop_cart_link_fragment');
}

// Header cart customization
////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////
// Product categories widget customization
add_action('widgets_init', function () {
    require_once get_template_directory().'/inc/bellashop_cat_list_walker.php';
    // WC_Widget_Product_Categories
    add_filter('woocommerce_product_categories_widget_args', 'bellashop_set_cat_walker', 10, 1);
    function bellashop_set_cat_walker($args)
    {
        $args['walker'] = new Bellashop_cat_list_walker();
        //$args['show_count'] = true;

        return $args;
    }
});

// Product categories widget customization
////////////////////////////////////////////////////////////////////////

// (place the following in functions.php)
