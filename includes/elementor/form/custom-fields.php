<?php

use \ElementorPro\Modules\Forms\Fields\Field_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * 
 * Custom Elementor Form Fields
 */

class Custom_Select_Field extends Field_Base
{
    public function get_name(): string
    {
        return 'נושא פנייה';
    }

    public function get_type()
    {
        return 'custom_select';
    }
    public function update_controls($widget): void
    {
        $elementor = \ElementorPro\Plugin::elementor();

        $control_data = $elementor->controls_manager->get_control_from_stack($widget->get_unique_name(), 'form_fields');

        if (is_wp_error($control_data)) {
            return;
        }
        $field_controls = [
            'placeholder' => [
                'name' => 'placeholder',
                'label' => esc_html__('Placeholder', 'textdomain'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'field_type' => $this->get_type(),
                ],
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
        ];

        $control_data['fields'] = $this->inject_field_controls($control_data['fields'], $field_controls);

        $widget->update_control('form_fields', $control_data);
    }

    public function render($item, $item_index, $form)
    {
        wp_reset_query();
        $form_id = $form->get_id();
        $field_type = $this->get_type();
        $options = $this->get_acf_repeater_options();
        $form->add_render_attribute(
            "select_$item_index",
            [
                'class' => 'elementor-field-textual',
                'type' => 'select',
                'autocomplete' => 'off',
            ]
        );
        $placeholder = $item['placeholder'];

        $field = "<div class='elementor-field elementor-select-wrapper'>";
        if (empty($options)) {
            echo "<input type='text' class=\"retreat-select-input\" id=\"{$item['_id']}_{$item_index}\" name=\"form_fields[field_{$item['_id']}]\">";
            return;
        } else{
            $field .= "<select class=\"retreat-select-input\" id=\"{$item['_id']}_{$item_index}\" name=\"form_fields[field_{$item['_id']}]\">";
            if (!empty($placeholder)) {
                $field .= "<option value=\"\" disabled selected>$placeholder</option>";
            }
            foreach ($options as $option) {
                $field .= "<option value=\"$option\">$option</option>";
            }
            $field .= '</select>';
        }
        $field .= '</div>';
        echo $field;
    }

    private function get_acf_repeater_options()
    {
        $options = [];
        $term = get_queried_object();
        $term_id = $term->term_id;
        $repeater = get_field('form_options', "department_$term_id") ?? [];
        if (empty($repeater))
            return [];
        foreach ($repeater as $option) {
            $options[] = $option['option'];
        }
        return $options;
    }
}