<?php 

  get_header();

  /* Counting Posts */
  while(have_posts()) {
      // the current post
      the_post(); ?>
      <h1>Page, not a post</h1>
      <h2><?php the_title();  ?></h2>
      <?php the_content();  ?>
     
  <?php 

  }

  get_footer();
  
?>


