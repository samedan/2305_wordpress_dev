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
        $pastEvents->the_post(); ?>

              <div class="event-summary">  
              <a class="event-summary__date t-center" href="#">
                  <span class="event-summary__month">
                    <!-- Month -->
                    <?php 
                      $eventDate = new DateTime(get_field('event_date'));
                      echo $eventDate->format('M');        
                    ?></span>
                    <!-- Day -->
                  <span class="event-summary__day"><?php echo $eventDate->format('d'); ?></span>
                </a>
                <div class="event-summary__content">
                  <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>"><?php the_title()  ?></a></h5>
                  <p> <?php echo wp_trim_words(get_the_content(), 18) ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
                </div>
              </div> 

      <?php
      }
      
      echo paginate_links(array(
        'total' => $pastEvents->max_num_pages
      ));
      
      ?>


    </div>

<?php 

get_footer();
?>
