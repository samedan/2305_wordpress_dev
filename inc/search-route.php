<?php 

///////////////
// FUNCTIONS
function universityRegisterSearch () {

 //  /wp-json/university/v1/search
 register_rest_route(
   'university/v1', // namespace= wp/v1 -> /wp-json/wp/v2/professor?search=biology
   'search', // route
   array(
    'methods' => WP_REST_SERVER::READABLE, // CRUD
    'callback' => 'universitySearchResults'
   )); 
}


function universitySearchResults($data) {
  $professors = new WP_Query(array(
    'post_type' => 'professor',
    's' => sanitize_text_field($data['term'])  // s=search with parameters $data (...?term=barksalot)
  ));

  $professorResults = array();

  while($professors->have_posts()) {
    $professors->the_post();
    array_push($professorResults, array(
     'title' => get_the_title(),
     'permalink' => get_the_permalink(),
    ));
  }

  return $professorResults;
}



///////////////
// NAME FUNCTIONS

add_action('rest_api_init', 'universityRegisterSearch');

?>
