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
