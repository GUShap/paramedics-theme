<?php

if (!defined('ABSPATH'))
    exit;  // Exit if accessed directly

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;

class Department_Title_Tag extends Tag
{

    // Define the tag name
    public function get_name()
    {
        return 'department-title';
    }

    // Define the tag title
    public function get_title()
    {
        return __('Department Title', 'plugin-name');
    }

    // Set the tag group (custom category under GS Tags)
    public function get_group()
    {
        return 'gs-tags';  // Custom group "GS Tags"
    }

    public function get_categories()
    {
        return [Module::TEXT_CATEGORY];  // Allow this tag to be used in dynamic fields
    }

    // Render the tag output (the department title)
    public function render()
    {
        global $wp_query;

        // Get the current term object for the "department" taxonomy
        $term = $wp_query->loop_term ?? get_queried_object();
        $title = $term->name ?? 'No Department Title';
        // Check if we are on a valid term and it's the 'department' taxonomy
        echo $title;
    }
}

class Department_Link_Tag extends Tag  {
    public function get_name() {
        return 'department-link';
    }

    public function get_title() {
        return __('Department Link', 'plugin-name');
    }

    public function get_group() {
        return 'gs-tags';
    }

    public function get_categories() {
        return [Module::URL_CATEGORY];
    }

    public function render() {
        global $wp_query;

        $term = $wp_query->loop_term ?? get_queried_object();
        $link = get_term_link($term);
        echo $link;
    }
}

class Department_Description_Tag extends Tag  {
    public function get_name() {
        return 'department-description';
    }

    public function get_title() {
        return __('Department Description', 'plugin-name');
    }

    public function get_group() {
        return 'gs-tags';
    }

    public function get_categories() {
        return [Module::TEXT_CATEGORY];
    }

    public function render() {
        global $wp_query;

        $term = $wp_query->loop_term ?? get_queried_object();
        $description = $term->description ?? 'No Department Description';
        echo $description;
    }
}