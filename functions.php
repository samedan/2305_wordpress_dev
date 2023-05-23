<?php 

 function university_files() {
   // load styles.css
   wp_enqueue_style('university_main_styles', get_stylesheet_uri());
 }

 // load file = wp_enqueue_scripts
 add_action('wp_enqueue_scripts', 'university_files');
