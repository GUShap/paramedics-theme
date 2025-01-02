<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit;

class Journey_Sign_Up_Form extends Widget_Base
{

    public function get_name()
    {
        return 'journey_sign_up_form';
    }

    public function get_title()
    {
        return __('Journey Sign Up Form', 'paramedics-theme');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories()
    {
        return ['gs-widgets'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'paramedics-theme'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'paramedics-theme'),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __('Enter your title', 'paramedics-theme'),
                'default' => __('', 'paramedics-theme'),
                'description' => __('Use {journey_title} to display the journey title.', 'paramedics-theme'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'paramedics-theme'),
                'type' => Controls_Manager::WYSIWYG,
                'input_type' => 'text',
                'placeholder' => __('Enter your description', 'paramedics-theme'),
                'default' => __('', 'paramedics-theme'),
            ]
        );

        $this->add_control(
            'open_popup_button_text',
            [
                'label' => __('Open Popup Button Text', 'paramedics-theme'),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __('Enter your button text', 'paramedics-theme'),
                'default' => __('הרשמה', 'paramedics-theme'),
            ]
        );

        $this->add_control(
            'submit_button_text',
            [
                'label' => __('Submit Button Text', 'paramedics-theme'),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text',
                'placeholder' => __('Enter your button text', 'paramedics-theme'),
                'default' => __('שליחה', 'paramedics-theme'),
            ]
        );

        // loader icon (png or svg)
        $this->add_control(
            'loader_icon',
            [
                'label' => __('Loader Icon', 'paramedics-theme'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Form Style', 'paramedics-theme'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        // form width
        $this->add_control(
            'form_width',
            [
                'label' => __('Form Width', 'paramedics-theme'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .inner' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'form_background_color',
            [
                'label' => __('Form Background Color', 'paramedics-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f7f7f7',
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .inner' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'form_padding',
            [
                'label' => __('Form Padding', 'paramedics-theme'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'label' => __('Form Border', 'paramedics-theme'),
                'selector' => '{{WRAPPER}} .sign-up-container .form-wrapper .inner',
            ]
        );
        // border radius
        $this->add_control(
            'form_border_radius',
            [
                'label' => __('Form Border Radius', 'paramedics-theme'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // title color, typography , alignment

        $this->add_control(
            'title_alignment',
            [
                'label' => __('Alignment', 'paramedics-theme'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .form-title' => 'text-align:{{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'paramedics-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .form-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'paramedics-theme'),
                'selector' => '{{WRAPPER}} .sign-up-container .form-wrapper .form-title',
            ]
        );

        $this->add_control(
            'description_alignment',
            [
                'label' => __('Alignment', 'paramedics-theme'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .form-description' => 'text-align:{{VALUE}};',
                ],
            ]
        );


        // description color & typography
        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'paramedics-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .sign-up-container .form-wrapper .form-description' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __('Description Typography', 'paramedics-theme'),
                'selector' => '{{WRAPPER}} .sign-up-container .form-wrapper .form-description',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'button_style',
            [
                'label' => __('Open Popup Button Style', 'paramedics-theme'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // align button
        $this->add_control(
            'button_alignment',
            [
                'label' => __('Alignment', 'paramedics-theme'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'right' => [
                        'title' => __('Right', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'left' => [
                        'title' => __('Left', 'paramedics-theme'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .open-popup-button-wrapper' => 'display:flex;justify-content:{{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __('Button Background Color', 'paramedics-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#007bff',
                'selectors' => [
                    '{{WRAPPER}} .open-popup-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Button Text Color', 'paramedics-theme'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .open-popup-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => __('Button Padding', 'paramedics-theme'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .open-popup-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Typography', 'paramedics-theme'),
                'selector' => '{{WRAPPER}} .open-popup-button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Button Border', 'paramedics-theme'),
                'selector' => '{{WRAPPER}} .open-popup-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Button Border Radius', 'paramedics-theme'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .open-popup-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
        $journey_data = $this->get_journey_data();
        $form_title = $this->process_text_variables($settings['title'], $journey_data['id']);
        $form_description = $this->process_text_variables($settings['description'], $journey_data['id']);
        $sign_up_form_template = require CHILD_THEME_DIR . '/includes/elementor/templates/journey-sign-up-form.php';

        if (file_exists($sign_up_form_template)) {
            include $sign_up_form_template;
        }
    }

    private function get_journey_data()
    {
        $id = get_the_ID();
        $title = get_the_title($id);
        $location = get_field('location', $id);
        $payment = get_field('payment', $id);
        $dates = get_field('dates', $id);
        return [
            'id' => $id,
            'title' => $title,
            'location' => $location,
            'dates' => $dates,
            'payment' => $payment,
        ];
    }

    private function process_text_variables($text, $journey_id)
    {
        // if text contains {journey_title} replace it with the journey title
        if (strpos($text, '{journey_title}') !== false) {
            $journey_title = get_the_title($journey_id);
            $text = str_replace('{journey_title}', $journey_title, $text);
        }
        return $text;
    }
}
