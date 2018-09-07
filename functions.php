<?php

// Menus theme support
add_theme_support('menus');

// Register menu locaitons
register_nav_menus(array(
    'primary' => __('Primary Menu'),
));

require get_template_directory().'/inc/bellashop_nav_menu_walker.php';
