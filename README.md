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

# Date And Time

> https://wordpress.org/documentation/article/customize-date-and-time-format/

# Archive for Author and Category

> archive.php
>
> <?php the_archive_title() ?>

#############

# Custom query

#############

> $homepagePosts = new WP_Query();

# Create Custom type (1) in functions.php

> function university_post_types() {}
>
> > https://developer.wordpress.org/reference/functions/register_post_type/

# Create a Must Use Plugin (2)

> Folder : app\public\wp-content

# Custom Type (event) Article post

> single-event.php

# Custom Type (event) Article Archive

> archive-event.php

# Past events

> page-past-events.php

# Add PROGRAMS

> university-post-types.php
> single-program, archive-program, functions.php

# Professor image

> 1. functions.php -> add_theme_support('post-thumbnails');
> 2. mu-plugins -> 'supports' => array('title', 'editor', 'thumbnail'),
> 3. functions->university_features-> add_image_size

## NODE JS

> https://www.npmjs.com/package/@wordpress/scripts

## Campuses Location

> Plugin: ACF OpenStreetMap Field

## Get the site URL

> load website URL in functions.php
> wp_localize_script('main-university-js', 'universityData', array(
> 'root_url' => get_site_url(),
> ));

## Return personalized JSON results from Query with CUSTOM API

> /inc/search-route.php
> Search.js for teh front-end

## Search based on relationships (Professor has Related program Biology)

> $programRelationshipQuery in search-route.php

## Change main text body to Main_Body_Content custom field

> single-program.php
> the_content() -> the_field('main_body_content')
> removed 'editor' from register_post_type('program') in university-post-types.php

## Search results without JS

> search.php
> use get_template_part(template-parts/content-professor)
> /template-parts/contentXYZ.php
> Duplicate Form in searchform.php

## Users with Event Planner capability

> Members plugin, Members->Roles
> edit university-post-types.php -> 'capability_type'=> 'event'
> Check plugin

## Load CSS on Login page / New Title

> functions.php -> add_action 'login_enqueue_scripts'...
