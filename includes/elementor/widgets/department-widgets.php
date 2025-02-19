<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Department_Information extends Widget_Base
{

    // Widget name
    public function get_name()
    {
        return 'department_information';
    }

    // Widget title
    public function get_title()
    {
        return __('Department Information', 'text-domain');
    }

    // Widget icon
    public function get_icon()
    {
        return 'eicon-post-list';
    }

    // Widget category
    public function get_categories()
    {
        return ['gs-widgets']; // Add to general category, or create a custom one.
    }

    // Widget controls (none needed for this example)
    protected function _register_controls()
    {
        // Content Controls
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'text-domain'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'text-domain'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .department-information .grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
                ],
            ]
        );

        $this->end_controls_section();

        // General Style Controls
        $this->start_controls_section(
            'general_style_section',
            [
                'label' => __('General Style', 'text-domain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'items_spacing',
            [
                'label' => __('Items Spacing', 'text-domain'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .department-information .grid' => 'gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'items_background',
            [
                'label' => __('Background Color', 'text-domain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .department-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'items_padding',
            [
                'label' => __('Items Padding', 'text-domain'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .department-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'items_border',
                'label' => __('Border', 'text-domain'),
                'selector' => '{{WRAPPER}} .department-item',
            ]
        );

        $this->add_control(
            'items_border_radius',
            [
                'label' => __('Border Radius', 'text-domain'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .department-item' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style Controls
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => __('Title', 'text-domain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'text-domain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .department-item .department-item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Typography', 'text-domain'),
                'selector' => '{{WRAPPER}} .department-item .department-item-title',
            ]
        );

        $this->add_responsive_control(
            'title_alignment',
            [
                'label' => __('Alignment', 'text-domain'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'text-domain'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'text-domain'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'text-domain'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .department-item .department-item-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Description Style Controls
        $this->start_controls_section(
            'description_style_section',
            [
                'label' => __('Description', 'text-domain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'text-domain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .department-item .department-item-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __('Typography', 'text-domain'),
                'selector' => '{{WRAPPER}} .department-item .department-item-description',
            ]
        );

        $this->add_responsive_control(
            'description_alignment',
            [
                'label' => __('Alignment', 'text-domain'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'text-domain'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'text-domain'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'text-domain'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .department-item .department-item-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Link Style Controls
        $this->start_controls_section(
            'link_style_section',
            [
                'label' => __('Link', 'text-domain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => __('Color', 'text-domain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .department-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'link_typography',
                'label' => __('Typography', 'text-domain'),
                'selector' => '{{WRAPPER}} .department-item a',
            ]
        );

        $this->add_responsive_control(
            'link_alignment',
            [
                'label' => __('Alignment', 'text-domain'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'text-domain'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'text-domain'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'text-domain'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .department-item .department-item-link-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Icon Style Controls
        $this->start_controls_section(
            'icon_style_section',
            [
                'label' => __('Icon', 'text-domain'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_width',
            [
                'label' => __('Width', 'text-domain'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .department-item img' => 'width: {{SIZE}}px;',
                    '{{WRAPPER}} .department-item .dashicons::before' => 'font-size: {{SIZE}}px;',
                    '{{WRAPPER}} .department-item .dashicons'=> 'height:{{SIZE}}px;'
                ],
            ]
        );


        $this->add_responsive_control(
            'icon_alignment',
            [
                'label' => __('Alignment', 'text-domain'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'text-domain'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'text-domain'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'text-domain'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .department-item .department-item-image-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dashicon_color',
            [
                'label' => __('Dashicon Color', 'text-domain'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .department-item .dashicons::before' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    // Widget render method
    protected function render()
    {
        // Check if we're on a taxonomy term page
        if (!is_tax('department')) {
            return;
        }

        // Get current term ID
        $term_id = get_queried_object_id();
        $department_information = get_field('department_information', "term_$term_id");
        $template_path = CHILD_THEME_DIR . '/includes/elementor/templates/department-information.php';

        if (file_exists($template_path)) {
            include $template_path;
        }
    }
}

