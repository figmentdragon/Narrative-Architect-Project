<?php

/**
 * Social Sharing Hook
 * @since 1.0.0
 *
 * @param int $post_id
 * @return void
 *
 */
if (!function_exists('creativity_social_sharing')) :
    function creativity_social_sharing($post_id)
    {
        $creativity_url = get_the_permalink($post_id);
        $creativity_title = get_the_title($post_id);
        $creativity_image = get_the_post_thumbnail_url($post_id);

        //sharing url
        $creativity_twitter_sharing_url = esc_url('http://twitter.com/share?text=' . $creativity_title . '&url=' . $creativity_url);
        $creativity_facebook_sharing_url = esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $creativity_url);
        $creativity_pinterest_sharing_url = esc_url('http://pinterest.com/pin/create/button/?url=' . $creativity_url . '&media=' . $creativity_image . '&description=' . $creativity_title);
        $creativity_linkedin_sharing_url = esc_url('http://www.linkedin.com/shareArticle?mini=true&title=' . $creativity_title . '&url=' . $creativity_url);

        ?>
        <div class="post-share">
            <a target="_blank" href="<?php echo $creativity_facebook_sharing_url; ?>"><i class="fa fa-facebook"></i></a>
            <a target="_blank" href="<?php echo $creativity_twitter_sharing_url; ?>"><i
                        class="fa fa-twitter"></i></a>
            <a target="_blank" href="<?php echo $creativity_pinterest_sharing_url; ?>"><i
                        class="fa fa-pinterest"></i></a>
            <a target="_blank" href="<?php echo $creativity_linkedin_sharing_url; ?>"><i class="fa fa-linkedin"></i></a>
        </div>
        <?php
    }
endif;
add_action('creativity_social_sharing', 'creativity_social_sharing', 10);
