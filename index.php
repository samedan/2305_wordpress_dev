<?php 
  /* Counting Posts */
  while(have_posts()) {
      // the current post
      the_post(); ?>
      <h2><?php the_title();  ?></h2>
  <?php 

  }
  
?>


