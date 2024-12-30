<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function register_widgets($widgets_manager)
{
    require_once CHILD_THEME_DIR . '/includes/elementor/widgets/parallax-section.php'; // Path to the widget file
    require_once CHILD_THEME_DIR . '/includes/elementor/widgets/journey-widgets.php'; // Path to the widget file

    $widgets_manager->register_widget_type(new \Elementor\Parallax_Section());
    $widgets_manager->register_widget_type(new \Elementor\Journey_Sign_Up_Form());
}
add_action('elementor/widgets/register', 'register_widgets');
function register_tags($manager)
{
    // Register the "Department Title" dynamic tag in Elementor
    require_once CHILD_THEME_DIR . '/includes/elementor/tags/team-department-tags.php';
    require_once CHILD_THEME_DIR . '/includes/elementor/tags/trip-tags.php';

    // team department tags
    $manager->register(new Department_Title_Tag());
    $manager->register(new Department_Link_Tag());
    $manager->register(new Department_Description_Tag());

    // trip tags
    $manager->register(new Next_Departure_Date());

    //  Register the "GS Tags" group
    $manager->register_group(
        'gs-tags',
        [
            'title' => esc_html__('GS Tags', 'textdomain')
        ]
    );
}
add_action('elementor/dynamic_tags/register', 'register_tags');

// register elementor widgets category called "GS Widgets"
function add_elementor_widget_categories($elements_manager)
{
    $elements_manager->add_category(
        'gs-widgets',
        [
            'title' => __('GS Widgets', 'gs-widgets'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'add_elementor_widget_categories');

/* enqueue scripts and styles */
function gs_enqueue_scripts()
{
    wp_enqueue_style('gs-style', CHILD_THEME_URI . '/assets/css/front.css', array(), false, 'all');
    wp_enqueue_style('gs-elementor-style', CHILD_THEME_URI . '/assets/css/elementor.css', array(), false, 'all');
    wp_enqueue_script('gs-script', CHILD_THEME_URI . '/assets/js/front.js', array('jquery'), false, true);
}

add_action('wp_enqueue_scripts', 'gs_enqueue_scripts');

// 

add_action('template_redirect', function () {
    // $participants = [
    //     [
    //         'name' => 'John Doe',
    //         'age' => 25,
    //         'city' => 'New York',
    //     ],
    //     [
    //         'name' => 'Jane Doe',
    //         'age' => 30,
    //         'city' => 'Los Angeles',
    //     ],
    // ];
    // $departure_dates = get_field('dates', 648);
    // $departure_dates[0]['participants_list'] = json_encode($participants);
    // update_field('dates', $departure_dates, 648);
    // dd($departure_dates);
});