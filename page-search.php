<?php 

  get_header();

  /* Counting Posts */
  while(have_posts()) {
      // the current post
      the_post(); 
      pageBanner();
      ?>
      
    

    <div class="container container--narrow page-section">

       <!-- BREADCRUMB -->
       <?php 
          $theParent = wp_get_post_parent_id(get_the_ID());
          
          // echo wp_get_post_parent_id(get_the_ID()); 0 if the page IS a PARENT
          if($theParent) {
            // echo "CHILD Page";
            ?>
              <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                  <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>">
                  <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent) ?></a> 
                  <span class="metabox__main"><?php the_title() ?></span>
                </p>
              </div>
            <?php 
          }
          
       ?>
      

      <!-- Sidebar on the right -->
      <?php 
          // verify is a Parent page has Children
          $testArray = get_pages(array(
            'child_of' => get_the_ID()
          ));
          if($theParent or $testArray) {
      ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent)  ?></a></h2>
        <ul class="min-list">
          <?php 
              // get the ID if Parent or Child
              if($theParent) {
                // CHILD
                $findChildrenOf = $theParent;
              } else {
                // PARENT
                $findChildrenOf = get_the_ID();
              }
              wp_list_pages(array(
                'title_li' => NULL, // Name of the Parent nor displayed (null)
                'child_of' => $findChildrenOf,
                'sort_column' => 'menu_order'
              ));
          ?>
          <!-- <li class="current_page_item"><a href="#">Our History</a></li>
          <li><a href="#">Our Goals</a></li> -->
        </ul>
      </div>
      <?php } ?>
      <!-- END Sidebar on the right -->
  
      <!-- Search Form -->
      <div class="generic-content">
          <?php get_search_form(); ?>
      </div>

    </div>
      
     
  <?php 

  }

  get_footer();
  
?>


