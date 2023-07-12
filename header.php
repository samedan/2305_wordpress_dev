<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset') ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
</head>
<body <?php body_class(); ?>>
    <header class="site-header">
      <div class="container">
        <h1 class="school-logo-text float-left">
          <a href="<?php echo site_url('/') ?>"><strong>Fictional</strong> University</a>
        </h1>
        <a href="<?php esc_url(site_url('/search')) ?>" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
            <!-- <?php 
                wp_nav_menu(array(
                    'theme_location' => 'headerMenuLocation'
                ));
            ?> -->
            <ul>
                <!-- Check to see if the current page or child page (13 is id for Parent) -->
              <li <?php if(is_page('about-us') or wp_get_post_parent_id(0) == 13) echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
              <li <?php if(get_post_type() == 'program') echo 'class="current-menu-item"' ?>>
                <a href="<?php echo get_post_type_archive_link('program'); ?>">
                  Programs
                </a>
              </li>
              <li  
              <?php 
              if(get_post_type() == 'event' OR 
                 is_page('past-events')
              ) echo 'class="current-menu-item"' 
              ?>
              ><a href="<?php echo get_post_type_archive_link('event') ?>">Events</a></li>
              <li  
              <?php 
              if(get_post_type() == 'campus'
              ) echo 'class="current-menu-item"' 
              ?>
              ><a href="<?php echo get_post_type_archive_link('campus') ?>">Campuses</a></li>
            
              <li <?php if(get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/blog'); ?>">Blog</a></li>
            </ul>
          </nav>

          <!-- Login SignUP -->
          <div class="site-header__util">
            <?php 
                if(is_user_logged_in()) { ?>
                  <a href="<?php echo wp_logout_url(); ?>" class="btn btn--small btn--dark-orange float-left push-right btn--with-photo"          >
                     <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
                     <span class="btn__text">Log Out</span></a>
                  <?php 
                } else { ?>
                      <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
                      <a href="<?php echo esc_url(site_url('/wp-signup.php')); ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                  <?php 
                }
            ?>
            
            <a href="<?php esc_url(site_url('/search')) ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </header>
