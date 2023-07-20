<?php 
   add_action('rest_api_init', 'universityLikeRoutes');

   function universityLikeRoutes() {
      // POST  
      register_rest_route(
        'university/v1',
        'manageLike',
        array(
         'methods' => 'POST',
         'callback' => 'createLike',
        )
      );
      // DELETE
      register_rest_route(
        'university/v1',
        'manageLike',
        array(
         'methods' => 'DELETE',
         'callback' => 'deleteLike',
        )
      );
   }

   function createLike($data) {
      if(is_user_logged_in()) {
        $professor = sanitize_text_field($data['professorId']); // professorId sent from Like.js

        // Check for existing Like for a professor
        $existQuery = new WP_Query(array(
          'author' => get_current_user_id(),
          'post_type' => 'like',
          'meta_query' => array(
            array(
              'key' => 'liked_professor_id', // name of custom field
              'compare' => '=',
              'value' => $professor
            )
          ),
        ));

        if($existQuery->found_posts == 0 AND get_post_type($professor) == 'professor' ){
            // create NEW Like 
            return wp_insert_post(array( // if successfull it retunrs the ID
              'post_type' => 'like',
              'post_status' => 'publish', // default is draft
              'post_title' => '2nd PHP test', 
              'meta_input' => array(
                'liked_professor_id' => $professor         
              )
            ));
        } else {
          die("Invalid professor id");
        }        
      } else {
        die("Only logged in users can create a like.");
      }  
   }
   function deleteLike() {
      return 'Delete like';
   }

?>
