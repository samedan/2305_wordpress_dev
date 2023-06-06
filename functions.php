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
  register_nav_menu('headerMenuLocation', 'Header Menu Location');
  register_nav_menu('footerLocationOne', 'Footer Location One');
  register_nav_menu('footerLocationTwo', 'Footer Location Two');
}




///////////////
// NAME FUNCTIONS

 // load file = wp_enqueue_scripts
 add_action('wp_enqueue_scripts', 'university_files');

 // generate META Title tag & MENU
 add_action('after_setup_theme', 'university_features');

