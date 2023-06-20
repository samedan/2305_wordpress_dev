<?php 
get_header();
pageBanner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events',
));
?>



    <div class="container container--narrow page-section">
      <?php
      // Calculate past dates
      $today = date('Ymd');
            
            $pastEvents = new WP_Query(array(
              'paged' => get_query_var('paged', 1),// which page nr of results it should be on, '1' is default is another is not shown
              // 'posts_per_page'=> 1, // "-1" = all posts that meat the query
              'post_type' => 'event', // what data to query from teh DBB = Event
              'meta_key' => 'event_date', // custom field = 'event_date_num'
              'orderby' => 'meta_value_num', // 'meta_value' meta or custom field              
              'order' => 'ASC',
              'meta_query' => array(
                array( // only give events in the past
                  'key' => 'event_date',
                  'compare' => '<',
                  'value' => $today,
                  'type' => 'numeric' // date is a numeric type
                ),
                // array(), another sets of rules 
              )
            ));

      while($pastEvents->have_posts()) {
        $pastEvents->the_post();
        get_template_part('template-parts/content-event');
      }
      
      echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
      ));
      
      ?>


    </div>

<?php 

get_footer();
?>
