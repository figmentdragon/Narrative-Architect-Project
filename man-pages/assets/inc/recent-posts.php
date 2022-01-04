<?php /* called by <?php recent_posts(); ?> */ ?>

function recent_posts($no_posts = 3, $excerpts = true) {

   global $wpdb;

   $request = "SELECT ID, post_title, post_excerpt FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post' ORDER BY post_date DESC LIMIT $no_posts";

   $posts = $wpdb->get_results($request);

   if($posts) {

               foreach ($posts as $posts) {
                       $post_title = stripslashes($posts->post_title);
                       $permalink = get_permalink($posts->ID);

                       $output .= '<li><h2><a href="' . $permalink . '" rel="bookmark" title="Permanent Link: ' . htmlspecialchars($post_title, ENT_COMPAT) . '">' . htmlspecialchars($post_title) . '</a></h2>';

                       if($excerpts) {
                               $output.= '<br />' . stripslashes($posts->post_excerpt);
                       }

                       $output .= '</li>';
               }

       } else {
               $output .= '<li>No posts found</li>';
       }

   echo $output;
}
