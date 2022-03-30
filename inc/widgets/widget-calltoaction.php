<?php

/**
 * Call to Action Widget
 *
 * @package THEMENAME
 */

add_action('widgets_init', 'register_cta_simple_widget');

function register_cta_simple_widget() {
    register_widget('Cta_Simple');
}

class Cta_Simple extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'Cta_Simple', 'AP :  Call to Action', array(
                'description' => __('A widget that shows Simple Call to Action', 'TheCreativityArchitect')
            )
        );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            'cta_simple_title' => array(
                'widgets_name' => 'cta_simple_title',
                'widgets_title' => __('Title', 'TheCreativityArchitect'),
                'widgets_field_type' => 'text',
            ),
            'cta_simple_button_text' => array(
                'widgets_name' => 'cta_simple_button_text',
                'widgets_title' => __('Button Text', 'TheCreativityArchitect'),
                'widgets_field_type' => 'text',
            ),
            'cta_simple_button_url' => array(
                'widgets_name' => 'cta_simple_button_url',
                'widgets_title' => __('Button Url', 'TheCreativityArchitect'),
                'widgets_field_type' => 'text'

            )

        );

        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);
        $cta_simple_title = $instance['cta_simple_title'];
        $cta_simple_button_text = $instance['cta_simple_button_text'];
        $cta_simple_button_url = $instance['cta_simple_button_url'];
        echo wp_kses_post($before_widget);
        ?>
        <div class="cta-banner clearfix">

            <div class="cta-title_simple main-title"><?php echo esc_html($cta_simple_title);?></div>

            <?php if(!empty($cta_simple_button_text)){?>
                <div class="banner-button">
                    <a class="button" href="<?php echo esc_url($cta_simple_button_url); ?>"><?php echo esc_html($cta_simple_button_text); ?></a>
                </div>
            <?php } ?>

        </div>
        <?php
        echo wp_kses_post($after_widget);
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$widgets_name] = widgets_updated_field_value($widget_field, $new_instance[$widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            // Make array elements available as variables
            extract($widget_field);
            $widgets_field_value = !empty($instance[$widgets_name]) ? esc_attr($instance[$widgets_name]) : '';
            widgets_show_widget_field($this, $widget_field, $widgets_field_value);
        }
    }

}
