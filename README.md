# 2305_wordpress_dev

# Echo image/file

> <?php echo get_theme_file_uri('/images/ocean.jpg') ?>

# Get Website /root

> <?php echo site_url('/about-us') ?>

# Header META

> <?php wp_head(); ?>

# Footer

> <?php wp_footer(); ?>

# functions.php

> wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

## POST Id & POST Parent ID

> echo get_the_ID();
> echo wp_get_post_parent_id();

# Get Link

> get_permalink(id);
> the_title(); Post Title
> get_the_title($theParent); any page, including Parent page

# MENU

> 1. add_action in functions.php
>    register_nav_menu('headerMenuLocation', 'Header Menu Location');

> 2. Add Menu in BackEnd with Location

> 3. Add the menu in header.php
>    wp_nav_menu(array(
>    'theme_location' => 'headerMenuLocation'
>    ));
