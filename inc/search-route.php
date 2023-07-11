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

// UNIVERSAL Search
function universitySearchResults($data) {
  $mainQuery = new WP_Query(array(
    'post_type' => array(
      'post', 'page', 'professor', 'program', 'campus', 'event'
    ),
    's' => sanitize_text_field($data['term'])  // s=search with parameters $data (...?term=barksalot)
  ));

  $results = array(
    'generalInfo' => array(),
    'professors' => array(),
    'programs' => array(),
    'events' => array(),
    'campuses' => array(),
  );

  while($mainQuery->have_posts()) {
    $mainQuery->the_post();
    if(get_post_type() == 'post' OR get_post_type() == 'page') {
      array_push($results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'authorName' => get_the_author(),
       ));
    }
    if(get_post_type() == 'professor') {
      array_push($results['professors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'image' => get_the_post_thumbnail_url(
          0, // current post
          'professorLandscape' // size
        ),
       ));
    }
    if(get_post_type() == 'program') {
      $relatedCampuses = get_field('related_campus'); // related_campus is array
      if($relatedCampuses) {
        foreach($relatedCampuses as $campus) {
            array_push(
              $results['campuses'], 
              array(
                'title' => get_the_title($campus),
                'permalink' => get_the_permalink($campus)
              ));
        }
      }
      array_push($results['programs'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'id' => get_the_id() // use teh ID for relationships searches
       ));
    }
    if(get_post_type() == 'campus') {
      array_push($results['campuses'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
       ));
    }
    if(get_post_type() == 'event') {
      $eventDate = new DateTime(get_field('event_date'));
      $description = null;
      if(has_excerpt()) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words(get_the_content(), 18);
      }
      array_push($results['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => $eventDate->format('M'),
        'day' => $eventDate->format('d'),
        'description' => $description
       ));
    } 
  }

  // Only if there are program results 
  if($results['programs']) {
    $programsMetaQuery = array(
      'relation' => 'OR'
    );
  
    foreach($results['programs'] as $item) {
        array_push($programsMetaQuery, 
          array(
            'key' => 'related_programs', 
            'compare' => 'LIKE', 
            'value' => '"'.$item['id'].'"', // Biology=55
          )
      );
    }
  
    // Search based on relationships (Professor has Related program Biology)
    $programRelationshipQuery = new WP_Query(array(
      'post_type' => array(
        'professor', 
        'event'
      ),
      'meta_query' => $programsMetaQuery
    ));
  
    // Search based on relationships
    while($programRelationshipQuery->have_posts()) {
      $programRelationshipQuery->the_post();
  
      if(get_post_type() == 'event') {
          $eventDate = new DateTime(get_field('event_date'));
          $description = null;
          if(has_excerpt()) {
            $description = get_the_excerpt();
          } else {
            $description = wp_trim_words(get_the_content(), 18);
          }
          array_push($results['events'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'month' => $eventDate->format('M'),
            'day' => $eventDate->format('d'),
            'description' => $description
          ));
      } 
      if(get_post_type() == 'professor') {
          array_push($results['professors'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'image' => get_the_post_thumbnail_url(
              0, // current post
              'professorLandscape' // image size
            ),
          ));
      }
      
    }
  
    // remove duplicates
    $results['professors'] =
    array_values( // removes the "id0=" from "0": { "title": "Dr. Barksalot"...
     array_unique($results['professors'], SORT_REGULAR)
    );
    $results['events'] =
    array_values( // removes the "id0=" from "0": { "title": "Dr. Barksalot"...
     array_unique($results['events'], SORT_REGULAR)
    );
  }

  

  return $results;
}



///////////////
// NAME FUNCTIONS

add_action('rest_api_init', 'universityRegisterSearch');

?>
