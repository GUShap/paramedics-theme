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
        return ['gs-widgets'];
    }

    public function get_script_depends()
    {
        return ['swiper-js', 'testimonials-slider-js'];
    }

    public function get_style_depends()
    {
        return ['testimonials-slider-css'];
    }
    public function _register_controls()
    {

        $this->start_controls_section(
            'styleslider',
            [
                'label' => __('Slider', 'plugin-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // slider height
        $this->add_control(
            'slider_height',
            [
                'label' => __('Slider Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-slider-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // gap between main and thumbs slider
        $this->add_responsive_control(
            'slider_gap',
            [
                'label' => __('Gap Between Sliders', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-slider-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // seperator line between main and thumbs slider - width & color
        $this->add_control(
            'slider_seperator_width',
            [
                'label' => __('Seperator Width', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-slider-wrapper' => 'position: relative;',
                    '{{WRAPPER}} .testimonials-slider-wrapper:after' => 'content:"";position:absolute;top:0;left:50%;height:100%;width:{{SIZE}}{{UNIT}};transform:translateX(-50%);',
                ],
            ]
        );

        $this->add_control(
            'slider_seperator_color',
            [
                'label' => __('Seperator Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-slider-wrapper:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        // Style Tab: Main Slide
        $this->start_controls_section(
            'style_main_slide',
            [
                'label' => __('Main Slide', 'plugin-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'main_slide_background_color',
            [
                'label' => __('Background Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-main-slider .swiper-slide' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // video width, height, object fit, object position

        $this->add_control(
            'video_width',
            [
                'label' => __('Video Width', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-main-slider .swiper-slide video' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'video_height',
            [
                'label' => __('Video Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-main-slider .swiper-slide .video-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'video_object_fit',
            [
                'label' => __('Video Object Fit', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => 'Cover',
                    'contain' => 'Contain',
                    'fill' => 'Fill',
                    'none' => 'None',
                    'scale-down' => 'Scale Down',
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-main-slider .swiper-slide video' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_object_position',
            [
                'label' => __('Video Object Position', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'center' => 'Center',
                    'top' => 'Top',
                    'right top' => 'Right Top',
                    'right' => 'Right',
                    'right bottom' => 'Right Bottom',
                    'bottom' => 'Bottom',
                    'left bottom' => 'Left Bottom',
                    'left' => 'Left',
                    'left top' => 'Left Top',
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-main-slider .swiper-slide video' => 'object-position: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'main_title_typography',
                'label' => __('Title Typography', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .testimonials-main-slider .swiper-slide h3',
            ]
        );

        $this->add_control(
            'main_title_color',
            [
                'label' => __('Title Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-main-slider .swiper-slide h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'main_excerpt_typography',
                'label' => __('Excerpt Typography', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .testimonials-main-slider .swiper-slide .excerpt',
            ]
        );

        $this->add_control(
            'main_excerpt_color',
            [
                'label' => __('Excerpt Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-main-slider .swiper-slide .excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Tab: Thumbs Slide
        $this->start_controls_section(
            'style_thumbs_slide',
            [
                'label' => __('Thumbs Slide', 'plugin-domain'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // number of thumbs per view, steps of 0.5
        $this->add_control(
            'thumbs_per_view',
            [
                'label' => __('Thumbs Per View', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['custom'],
                'range' => [
                    'custom' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.5,
                    ]
                ],
            ]
        );

        $this->add_control(
            'thumbs_slide_background_color',
            [
                'label' => __('Background Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f9f9f9',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // slide padding
        $this->add_responsive_control(
            'thumbs_slide_padding',
            [
                'label' => __('Padding', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // image width
        $this->add_control(
            'thumbs_image_width',
            [
                'label' => __('Image Width', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // image height
        $this->add_control(
            'thumbs_image_height',
            [
                'label' => __('Image Height', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        // align image left/center/right
        $this->add_control(
            'thumbs_image_alignment',
            [
                'label' => __('Image Alignment', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'plugin-domain'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'plugin-domain'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'plugin-domain'),
                        'icon' => 'eicon-h-align-left',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide .image-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );


        // object fit
        $this->add_control(
            'thumbs_image_object_fit',
            [
                'label' => __('Image Object Fit', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => 'Cover',
                    'contain' => 'Contain',
                    'fill' => 'Fill',
                    'none' => 'None',
                    'scale-down' => 'Scale Down',
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
        // object position
        $this->add_control(
            'thumbs_image_object_position',
            [
                'label' => __('Image Object Position', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'center' => 'Center',
                    'top' => 'Top',
                    'right top' => 'Right Top',
                    'right' => 'Right',
                    'right bottom' => 'Right Bottom',
                    'bottom' => 'Bottom',
                    'left bottom' => 'Left Bottom',
                    'left' => 'Left',
                    'left top' => 'Left Top',
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide img' => 'object-position: {{VALUE}};',
                ],
            ]
        );

        // spacing of text items (using gap on flex column in .text-wrapper)
        $this->add_responsive_control(
            'thumbs_text_spacing',
            [
                'label' => __('Text Spacing', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide .text-wrapper' => 'display:flex;flex-direction:column;gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'thumbs_title_typography',
                'label' => __('Title Typography', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide h3',
            ]
        );

        $this->add_control(
            'thumbs_title_color',
            [
                'label' => __('Title Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'main_course_number_typography',
                'label' => __('Course Number Typography', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide .course-number',
            ]
        );

        $this->add_control(
            'main_course_number_color',
            [
                'label' => __('Course Number Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide .course-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        // excerpt
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'thumbs_excerpt_typography',
                'label' => __('Excerpt Typography', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide .excerpt',
            ]
        );

        $this->add_control(
            'thumbs_excerpt_color',
            [
                'label' => __('Excerpt Color', 'plugin-domain'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .testimonials-thumbs-slider .swiper-slide .excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
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
                'link' => get_permalink($testimonial->ID),
            ];
        }

        $testimonials_slides_template_path = CHILD_THEME_DIR . '/includes/elementor/templates/testimonials-slider.php';
        $thumbs_per_view = $settings['thumbs_per_view']['size'];
        if (file_exists($testimonials_slides_template_path)) {
            include $testimonials_slides_template_path;
        }

    }
}
