<?php

// Menus theme support
add_theme_support('menus');

add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

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
// Products loop customization

function bellashop_cart()
{
    echo '<div class="cart">';
    echo '<a href="#"></a>';
    echo '<i class="icon-bag"></i>';
    $count = WC()->cart->get_cart_contents_count();
    echo '<span class="count">'.$count.'</span>';
    echo '<span class="subtotal">'.WC()->cart->get_cart_subtotal().'</span>';
    echo '<div class="toolbar-dropdown">';
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
        $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
        echo sprintf('<div class="dropdown-product-item"><span class="dropdown-product-remove"><a href="%s"><i class="icon-cross"></i></a></span>', wc_get_cart_remove_url($cart_item_key));
        printf('<a class="dropdown-product-thumb" href="%s">%s</a>', esc_url($product_permalink), wp_kses_post($thumbnail));
        echo sprintf('<div class="dropdown-product-info"><a class="dropdown-product-title" href="%s">%s</a><span class="dropdown-product-details">%s</span></div>', esc_url($product_permalink), $product_name, $product_price);
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
}

add_action('bellashop_header_cart', 'bellashop_cart');

// Products loop customization
////////////////////////////////////////////////////////////////////////

// (place the following in functions.php)
