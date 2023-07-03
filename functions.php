<?php 

require get_theme_file_path('/inc/search-route.php');

///////////////
// FUNCTIONS

// add info to the REST API
function university_custom_rest() {
    register_rest_field('post', 'authorName', array(
      'get_callback' => function() {
        return get_the_author();
      }
    ));
}

// Page BANNER
function pageBanner($args = NULL) { // $args is optional
    if(!isset($args['title'])) { // only if title is not passed
      $args['title'] = get_the_title();
    } 
    if(!isset($args['subtitle'])) {
      $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!isset($args['photo'])) {
      if (get_field('page_banner_background_image') AND !is_archive() AND !is_home() ) {
        $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      } else {
        $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
      }
    }
    ?>
      <div class="page-banner">
      <!-- BACKGROUND Banner Image -->
      <div class="page-banner__bg-image" style="background-image: url(
        <?php 
          echo $args['photo'];
        ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']  ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle'] ?></p>
        </div>
      </div>
    </div>

    <?php 
}

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

   // load website URL
   wp_localize_script('main-university-js', 'universityData', array(
    'root_url' => get_site_url(),
   ));
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
  add_image_size('pageBanner', // Page BANNER
    1500, 
    350, 
    true // crop or not in center
  );
  register_nav_menu('headerMenuLocation', 'Header Menu Location');
  register_nav_menu('footerLocationOne', 'Footer Location One');
  register_nav_menu('footerLocationTwo', 'Footer Location Two');
}

// Pass queries for the Events page (archive-event)
function university_adjust_queries($query) {
  
  // PROGRAMS
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


  // CAMPUSES
  if( // only if not in the backend
    !is_admin() AND 
    // only on the '/campuses' page
    is_post_type_archive('campus') AND
    // it won't work on Custom Query, only main query (the default URL query)
    is_main_query()
    ) {      
      $query->set('posts_per_page', -1); // all posts
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

 // add info to the REST API
 add_action('rest_api_init', 'university_custom_rest');

// wp_enqueue_style('leaflet-map-css', '//unpkg.com/leaflet@1.8.0/dist/leaflet.css');
// wp_enqueue_script('leaflet-map-js', '//unpkg.com/leaflet@1.8.0/dist/leaflet.js',NULL,'1.8.0', false); 
