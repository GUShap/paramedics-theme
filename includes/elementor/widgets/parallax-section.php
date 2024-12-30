<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Parallax Section widget.
 *
 * Widget that allows adding a repeater control where each item is a different Elementor template.
 *
 * @since 1.0.0
 */
class Parallax_Section extends Widget_Base
{

    /**
     * Get widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     */
    public function get_name()
    {
        return 'parallax_section';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     */
    public function get_title()
    {
        return __('Parallax Section', 'gs-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     */
    public function get_icon()
    {
        return 'eicon-slider-full-screen';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     * @since 1.0.0
     */
    public function get_categories()
    {
        return ['gs-widgets'];
    }

    /**
     * Register widget controls.
     *
     * @since 1.0.0
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'gs-widgets'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'template_id',
            [
                'label' => __('Select Template', 'gs-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_elementor_templates(),
                'default' => '',
                'description' => __('Choose an Elementor template to display in this section.', 'gs-widgets'),
            ]
        );

        // Add a Background control group to the repeater
        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __('Background', 'gs-widgets'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );

        //    add switcher control to repeater of mode of section - dark or light
        $repeater->add_control(
            'section_mode',
            [
                'label' => __('Section Mode', 'gs-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Dark', 'gs-widgets'),
                'label_off' => __('Light', 'gs-widgets'),
                'return_value' => 'dark',
                'default' => 'light',
                'description' => __('Choose the mode of the section.', 'gs-widgets'),
            ]
        );

        $this->add_control(
            'parallax_sections',
            [
                'label' => __('Parallax Sections', 'gs-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => __('Section - {{{ template_id ? "Template ID: " + template_id : "No Template Selected" }}}', 'gs-widgets'),
            ]
        );

        $this->end_controls_section();
    }


    /**
     * Render the widget output on the frontend.
     *
     * @since 1.0.0
     */
    protected function render()
    {
        global $wp_query;

        $settings = $this->get_settings_for_display();

        if (!empty($settings['parallax_sections'])) {
            echo '<div class="parallax-section-wrapper">';
            foreach ($settings['parallax_sections'] as $idx => $section) {
                $section_mode = $section['section_mode'];
                $section_classes = "parallax-section-item {$section_mode}";
                if (!empty($section['section_class'])) {
                    $section_classes .= " {$section['section_class']}";
                }
                if (!$idx) {
                    $section_classes .= ' active';
                }
                if (!empty($section['template_id'])) {
                    echo "<section class='$section_classes' data-item='dynamic-section'>";
                    echo '<div class="parallax-section-content">';
                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($section['template_id'], true);
                    echo '</div>';
                    echo '</section>';
                }
            }
            echo '</div>';
        }
    }

    /**
     * Get Elementor templates.
     *
     * @return array List of Elementor templates.
     * @since 1.0.0
     */
    private function get_elementor_templates()
    {
        $templates = [];
        $template_query = new \WP_Query([
            'post_type' => 'elementor_library',
            'posts_per_page' => -1,
        ]);

        if ($template_query->have_posts()) {
            while ($template_query->have_posts()) {
                $template_query->the_post();
                $templates[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
        }

        return $templates;
    }
}

// Register the widget
add_action('elementor/widgets/register', function ($widgets_manager) {
    $widgets_manager->register(new Parallax_Section());
});
