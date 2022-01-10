<?php
// Plugin widget added using filters
function myprefix_starter_content_add_widget( $content, $config ) {
    if ( isset( $content['widgets']['sidebar-1'] ) ) {
        $content['widgets']['sidebar-1']['a_custom_widget'] = array(
            'my_custom_widget', array(
                'title' => 'A Special Plugin Widget',
            ),
        );
    }
    return $content;
}
add_filter( 'get_theme_starter_content', 'myprefix_starter_content_add_widget', 10, 2 );