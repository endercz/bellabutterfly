<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset') ?>">
    <title>
      <?php bloginfo( 'name' ); ?> |
      <?php is_front_page() ? bloginfo( 'description' ) : wp_title(); ?>
    </title>
    <!-- SEO Meta Tags -->
    <meta name="description" content="Bellashop - Sewing products shop">
    <meta name="keywords" content="shop, e-commerce, sewing, bags, wallets">
    <meta name="author" content="Hanus Hasl">

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/favicon.ico">
    <link rel="icon" type="image/png" href="favicon.png">

    <!-- Theme stylesheet -->
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" media="screen">

    <?php wp_head(); ?>
  </head>
  <!-- Body -->
  <body>
