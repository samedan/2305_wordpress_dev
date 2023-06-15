<?php 
  get_header();
  
  /* Counting Posts */
  while(have_posts()) {
      // the current post
      the_post(); ?>


    <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>)"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title();  ?></h1>
        <div class="page-banner__intro">
          <p>TO BE REPLACED</p>
        </div>
      </div>
    </div>
    <div class="container container--narrow page-section">
      <!-- Breadcrumbs -->
              <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                  <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>">
                  <i class="fa fa-home" aria-hidden="true"></i> All Programs
                  </a> 
                  <span class="metabox__main"><?php the_title() ?>
              </div>
              <!-- End Breadcrumbs -->

      <div class="generic-content">
        <?php the_content(); ?>
      </div>

      <!-- Custom query to get the EVENTs that has PROGRAMS -->
      <?php
            $today = date('Ymd');
            
            $homepageEvents = new WP_Query(array(
              'posts_per_page'=> 2, // "-1" = all posts that meat the query
              'post_type' => 'event', // what data to query from teh DBB = Event
              'meta_key' => 'event_date', // custom field = 'event_date_num'
              'orderby' => 'meta_value_num', // 'meta_value' meta or custom field              
              'order' => 'ASC',
              'meta_query' => array(
                array( // only give events in the future
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric' // date is a numeric type
                ),
                // get the programs
                array(
                 'key' => 'related_programs',
                 'compare' => 'LIKE',
                 'value' => '"'. get_the_ID().'"' // search for teh deseialized value "12"
                )
              )
            ));

            while($homepageEvents->have_posts()) {
              $homepageEvents->the_post(); ?>
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
                  <p> <?php 
                  if(has_excerpt()) {
                    echo get_the_excerpt();
                  } else {
                    echo wp_trim_words(get_the_content(), 18);
                  }
                  
                  ?> <a href="<?php the_permalink() ?>" class="nu gray">Learn more</a></p>
                </div>
              </div>
              <?php
            }
          ?>
      <!-- END Custom query to get the PROGRAMS -->

    </div>
      
      
     
  <?php 

  }
  
  get_footer();
?>


