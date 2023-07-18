<?php 
// /wp-content/mu-plugins

// Create Event Custom type
function university_post_types() {

  // CAMPUS post type
  register_post_type('campus', array(
    'capability_type' => 'campus',
    'map_meta_cap' => true,
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'excerpt'),
    'rewrite' => array('slug' => 'campuses'),
    'has_archive' => true,
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Campuses',
      'add_new_item' => 'Add New Campus',
      'edit_item' => 'Edit Campus',
      'all_items' => 'All Campuses',
      'singular_name' => 'Event',
    ),
    'menu_icon' => 'dashicons-location-alt'
  ));

  // EVENT post type
  register_post_type('event', array(
    'show_in_rest' => true,
    'capability_type'=> 'event', // user permissions
    'map_meta_cap' => true,
    'supports' => array('title', 'editor', 'excerpt'),
    'rewrite' => array('slug' => 'events'),
    'has_archive' => true,
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event',
    ),
    'menu_icon' => 'dashicons-calendar'
  ));

  // create PROGRAM Custom type
  register_post_type('program', array(
    'show_in_rest' => true,
    'supports' => array('title'),
    'rewrite' => array('slug' => 'programs'),
    'has_archive' => true,
    'public' => true,
    'show_in_rest' => true,
    'labels' => array(
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program',
    ),
    'menu_icon' => 'dashicons-awards'
  ));

  // create PROFRESSOR Custom type
  register_post_type('professor', array(
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'public' => true,
    'labels' => array(
      'name' => 'Professors',
      'add_new_item' => 'Add New Professor',
      'edit_item' => 'Edit Professor',
      'all_items' => 'All Professors',
      'singular_name' => 'Professor',
    ),
    'menu_icon' => 'dashicons-welcome-learn-more'
  ));

  // create NOTE Custom type
  register_post_type('note', array(
    'capability_type' => 'note',
    'map_meta_cap' => true, // enforce capability
    'show_in_rest' => true,
    'supports' => array('title', 'editor'),
    'public' => false,// NOT show, including Admin
    'show_ui' => true,// show in the Admin
    'labels' => array(
      'name' => 'Notes',
      'add_new_item' => 'Add New Note',
      'edit_item' => 'Edit Note',
      'all_items' => 'All Notes',
      'singular_name' => 'Note',
    ),
    'menu_icon' => 'dashicons-welcome-write-blog'
  ));
}






///////////////
// NAME FUNCTIONS

 // create Custom Post Type
 add_action('init', 'university_post_types');


 ?>
