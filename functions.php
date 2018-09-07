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

// Products loop customization
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

function bellashop_template_loop_product_link_open()
{
    global $product;

    $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);

    echo '<a href="'.esc_url($link).'" class="product-thumb">';
}
add_action('woocommerce_before_shop_loop_item', 'bellashop_template_loop_product_link_open', 10);

// Product thumbnails
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

function bellashop_template_loop_product_thumbnail()
{
    global $loop;
    global $product;
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($loop->post->ID), 'single-post-thumbnail');
    echo "<img src=$image[0] alt=\"Product\">";
}
add_action('woocommerce_before_shop_loop_item_title', 'bellashop_template_loop_product_thumbnail', 10);
