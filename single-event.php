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
                  <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event') ?>">
                  <i class="fa fa-home" aria-hidden="true"></i> Events Home
                  </a> 
                  <span class="metabox__main"><?php the_title() ?>
              </div>
              <!-- End Breadcrumbs -->

      <div class="generic-content">
        <?php the_content(); ?>
      </div>

      <!-- PROGRAMS -->
      <?php 
        $relatedPrograms = get_field('related_programs');
        if($relatedPrograms) {
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium">Related Programs(s):</h2>';
          echo '<ul class="link-list min-list">';
          // $relatedPrograms is an Array []
          foreach($relatedPrograms as $program) {
            ?>
            <li>
              <a href="<?php echo get_the_permalink($program); ?>">
                <?php echo get_the_title($program); ?>
              </a>
            </li>
            <?php      
          }
          echo '</ul>';
        }
        
      
      ?>
      <!-- END PROGRAMS -->

    </div>
      
      
     
  <?php 

  }
  
  get_footer();
?>


