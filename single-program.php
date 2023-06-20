<?php 
  
  get_header();

  
  /* Counting Posts */
  while(have_posts()) {
      // the current post
      the_post(); 
      pageBanner();
      ?>


 
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

      <!-- Custom query to get the EPROFESSORS that teach PROGRAMS -->
      <?php
            $today = date('Ymd');
            
            $relatedProfessors = new WP_Query(array(
              'posts_per_page'=> -1, // "-1" = all posts that meat the query
              'post_type' => 'professor', // what data to query from teh DBB = Event
              'orderby' => 'title', // alphabetically            
              'order' => 'ASC',
              'meta_query' => array(
                // get the programs
                array(
                 'key' => 'related_programs',
                 'compare' => 'LIKE',
                 'value' => '"'. get_the_ID().'"' // search for teh deseialized value "12"
                )
              )
            ));

            // PROFESSOR in PROGRAMS
            if($relatedProfessors->have_posts()) {
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">' .get_the_title() .' Professors</h2>';

              echo '<ul class="professor-cards">';
              while($relatedProfessors->have_posts()) {
                $relatedProfessors->the_post(); ?>
                <li class="professor-card__list-item">
                  <a class="professor-card" href="<?php the_permalink() ?>">
                      <img class="professor-card__image" 
                          src="<?php the_post_thumbnail_url('professorLandscape'); ?>" />
                      <span class="professor-card__name"><?php the_title(); ?></span>                       
                  </a>
                </li>
                
                <?php
              }
              echo '</ul>';
            }
            // END PROFESSOR in PROGRAMS


            
            
          ?>
      <!-- END Custom query to get the EPROFESSORS that teach PROGRAMS -->

          <?php 
              // the_ID(), resets the global 'post' ID in between queries
              wp_reset_postdata();
          ?>


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

            // EVENTS in PROGRAMS
            if($homepageEvents->have_posts()) {
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">Upcoming ' .get_the_title() .' Events</h2>';

              while($homepageEvents->have_posts()) {
                $homepageEvents->the_post();
                get_template_part('template-parts/content-event');
              }
            }
            // END EVENTS in PROGRAMS


            
            
          ?>
      <!-- END Custom query to get the PROGRAMS -->

    </div>
      
      
     
  <?php 

  }
  
  get_footer();
?>


