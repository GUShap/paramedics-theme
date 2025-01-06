<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Testimonials_Slider extends Widget_Base
{
    public function get_name()
    {
        return 'testimonials_slider';
    }

    public function get_title()
    {
        return __('Testimonials Slider', 'plugin-domain');
    }

    public function get_icon()
    {
        return 'eicon-slider-video'; // Choose an appropriate icon
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function get_script_depends()
    {
        return ['swiper-js', 'testimonials-slider-js'];
    }

    public function get_style_depends()
    {
        return ['testimonials-slider-css'];
    }

    protected function render()
    {
        // Query all testimonials
        $testimonials = get_posts([
            'post_type' => 'testimonial',
            'post_status' => 'publish',
            'numberposts' => -1,
        ]);

        $slides = [];
        foreach ($testimonials as $testimonial) {
            $slides[] = [
                'id' => $testimonial->ID,
                'title' => get_the_title($testimonial->ID),
                'excerpt' => get_the_excerpt($testimonial->ID),
                'main_image' => get_the_post_thumbnail_url($testimonial->ID, 'full'),
                'course_number' => get_field('course_number', $testimonial->ID),
                'video' => get_field('video', $testimonial->ID),
            ];
        }

        $testimonials_slides_template_path =  require CHILD_THEME_DIR . '/includes/elementor/templates/testimonials-slides.php';
        if (file_exists($testimonials_slides_template_path)) {
            require_once $testimonials_slides_template_path;
        }
        
    }
}
