<?php 
  get_header();


  /* Counting Posts */
  while(have_posts()) {
      // the current post
      the_post(); ?>
      <h2><a href="<?php the_permalink() ?>"><?php the_title();  ?></a></h2>
      <?php the_content();  ?>
      <hr>
  <?php 
  }

  get_footer();
  
?>



