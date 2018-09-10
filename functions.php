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
