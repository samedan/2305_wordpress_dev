<?php 

///////////////
// FUNCTIONS

// Add files
 function university_files() {
   // load Javascript
   wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true); // array('jquery') = dependencies
   // load styles.css
   wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
   wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));

   // load external
   wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
   wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
 }

 // Add Title Tag
function university_features() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails'); // ALLow images on post
  add_image_size('professorLandscape', 
    400, 
    260, 
    true // crop or not in center
  );
  add_image_size('professorPortrait', 
    480, 
    650, 
    true // crop or not in center
  );
  register_nav_menu('headerMenuLocation', 'Header Menu Location');
  register_nav_menu('footerLocationOne', 'Footer Location One');
  register_nav_menu('footerLocationTwo', 'Footer Location Two');
}

// Pass queries for the Events page (archive-event)
function university_adjust_queries($query) {
  

  if( // only if not in the backend
    !is_admin() AND 
    // only on the '/programs' page
    is_post_type_archive('program') AND
    // it won't work on Custom Query, only main query (the default URL query)
    is_main_query()
    ) {
      // Order alphabetically
      $query->set('orderby', 'title');
      $query->set('order', 'ASC');
      $query->set('posts_per_page', -1);
    }

  if(
    // only if not in the backend
    !is_admin() AND 
    // only on the '/events' page
    is_post_type_archive('event') AND 
    // it won't work on Custom Query, only main query (the default URL query)
    is_main_query()
    ) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date'); // custom field = 'event_date_num'
    $query->set('orderby', 'meta_value_num'); // 'meta_value' meta or custom field      
    $query->set('order', 'ASC'); // date of the event
    $query->set('meta_query', array(
      array( // only give events in the future
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric' // date is a numeric type
      ))); // 'meta_value' meta or custom field      
  }  
}


///////////////
// NAME FUNCTIONS

 // load file = wp_enqueue_scripts
 add_action('wp_enqueue_scripts', 'university_files');

 // generate META Title tag & MENU
 add_action('after_setup_theme', 'university_features');

 // pass queries before reading the DBB
 add_action('pre_get_posts', 'university_adjust_queries');
