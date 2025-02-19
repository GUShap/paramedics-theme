<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function register_widgets($widgets_manager)
{
    require_once CHILD_THEME_DIR . '/includes/elementor/widgets/parallax-section.php'; // Path to the widget file
    require_once CHILD_THEME_DIR . '/includes/elementor/widgets/journey-widgets.php'; // Path to the widget file
    require_once CHILD_THEME_DIR . '/includes/elementor/widgets/testimonials-widgets.php';
    require_once CHILD_THEME_DIR . '/includes/elementor/widgets/department-widgets.php';

    $widgets_manager->register_widget_type(new \Elementor\Parallax_Section());

    $widgets_manager->register_widget_type(new \Elementor\Journey_Sign_Up_Form());
    $widgets_manager->register_widget_type(new \Elementor\Journeys_Archive_Sign_Up_Form());

    $widgets_manager->register_widget_type(new \Elementor\Testimonials_Slider());

    $widgets_manager->register_widget_type(new \Elementor\Department_Information());
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

function register_new_form_fields($form_fields_registrar)
{

    require_once CHILD_THEME_DIR . '/includes/elementor/form/custom-fields.php';

    $form_fields_registrar->register(new \Custom_Select_Field());

}
add_action('elementor_pro/forms/fields/register', 'register_new_form_fields');
/* enqueue scripts and styles */
function gs_enqueue_scripts()
{

    wp_enqueue_style('gs-style', CHILD_THEME_URI . '/assets/css/front.css', array(), false, 'all');
    wp_enqueue_style('gs-elementor-style', CHILD_THEME_URI . '/assets/css/elementor.css', array(), false, 'all');

    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_style('testimonials-slider-css', CHILD_THEME_URI . '/assets/css/testimonials-slider.css');

    wp_enqueue_script('gs-script', CHILD_THEME_URI . '/assets/js/front.js', array('jquery'), false, true);
    wp_localize_script('gs-script', 'customVars', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('gs-nonce')));

    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@latest/swiper-bundle.min.js', [], null);
    wp_enqueue_script('testimonials-slider-js', CHILD_THEME_URI . '/assets/js/testimonials-slider.js', ['jquery', 'swiper-js'], null);

    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'gs_enqueue_scripts');

// enqueue admin scripts & styles
function gs_admin_enqueue_scripts()
{
    wp_enqueue_style('gs-admin-style', CHILD_THEME_URI . '/assets/css/admin.css', array(), false, 'all');
    wp_enqueue_script('gs-admin-script', CHILD_THEME_URI . '/assets/js/admin.js', array('jquery'), false, true);
}

add_action('admin_enqueue_scripts', 'gs_admin_enqueue_scripts');
/*********/
add_action('wp', 'force_elementor_css_reload_on_tax_pages');
function force_elementor_css_reload_on_tax_pages() {
    if (is_tax('department')) {
        // Regenerate Elementor CSS
        \Elementor\Plugin::instance()->files_manager->clear_cache();
        // \Elementor\Plugin::instance()->files_manager->clear_css_cache();
    }
}


/*********/
function allow_svg_upload($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');


/*********/

function render_trip_metabox()
{
    $is_admin = current_user_can('administrator');
    if (!$is_admin) {
        return;
    }

    $journey_id = get_the_ID();
    $journey_dates = get_field('dates', $journey_id) ?? [];
    $journey_statuses = get_field('journey_statuses', $journey_id) ?? [];
    $journey_contacts = get_field('journey_contacts', $journey_id) ?? [];
    $journey_managment_template_path = CHILD_THEME_DIR . '/includes/admin/templates/journey-management.php';

    if (empty($journey_dates)) {
        echo '<p>אין תאריכים למסע זה</p>';
        return;
    }
    if (file_exists($journey_managment_template_path)) {
        require_once $journey_managment_template_path;
    }
}

function add_trip_metabox()
{
    // Add the metabox to the "trip" post type edit screen
    add_meta_box(
        'trip_custom_metabox',            // Metabox ID
        __('ניהול תאריכי מסע / סדנה ' . get_the_title(), 'textdomain'), // Title
        'render_trip_metabox',            // Callback function to display content
        'trip',                           // Post type
        'normal',                         // Context (normal, side, or advanced)
        'default'                         // Priority (default, high, low)
    );
}
add_action('add_meta_boxes', 'add_trip_metabox');

function on_trip_update($post_id, $post, $update)
{
    if ($post->post_type != 'trip') {
        return;
    }
    $is_flexible = $_POST['is_flexible'];
    $participant_status = $_POST['participant_status'];
    $participant_contact = $_POST['participant_contact'];
    $journey_dates = get_field('dates', $post_id) ?? [];
    if (empty($journey_dates)) {
        return;
    }

    foreach ($journey_dates as $idx => $date) {
        $departure_date = $date['departure_date'];
        $participants = json_decode($date['participants']);
        foreach ($participants as $participant_idx => $participant) {
            $participants[$participant_idx]->is_flexible = $is_flexible[$departure_date][$participant_idx];
            $participants[$participant_idx]->status = $participant_status[$departure_date][$participant_idx];
            $participants[$participant_idx]->contact = $participant_contact[$departure_date][$participant_idx];
        }
        $journey_dates[$idx]['participants'] = json_encode($participants, JSON_UNESCAPED_UNICODE);
    }

    update_field('dates', $journey_dates, $post_id);
}
add_action('save_post', 'on_trip_update', 10, 3);
/*********/

/* AJAX Hooks */
// recieve ajax request for action journey_registration
function journey_registration_handler()
{
    $fields = $_POST;
    $nonce = $fields['security'];

    if (!wp_verify_nonce($nonce, 'gs-nonce')) {
        wp_send_json_error('Invalid nonce');
    }

    $widget_id = $fields['widget_id'];
    $journey_id = $fields['journey_id'];
    $journey_date = $fields['journey_date'];
    $participant = [
        'name' => $fields['full_name'],
        'email' => $fields['email'],
        'phone' => $fields['phone'],
        'dob' => $fields['dob'],
        'gender' => $fields["{$widget_id}_gender"],
        'training_type' => $fields['training_type'],
        'training_number' => $fields['training_number'],
        'training_institution' => $fields['training_institution'],
        'unit' => $fields['unit'],
        'journey_date' => $fields['journey_date'],
        'is_flexible' => !empty($fields['flexability']),
        'status' => '',
        'contact' => ''
    ];

    $res = add_journey_participant($journey_id, $journey_date, $participant);
    if ($res['status'] == 'error') {
        wp_send_json_error($res);
    }
    wp_send_json_success($res);
}
add_action('wp_ajax_journey_registration', 'journey_registration_handler');
add_action('wp_ajax_nopriv_journey_registration', 'journey_registration_handler');


function save_participant_data_handler()
{
    $post_id = $_POST['post_id'];
    $departure_date = $_POST['departure_date'];
    $user_index = $_POST['index'];
    $participant_data = $_POST['participant_data'];
    $res = save_participant_data($post_id, $departure_date, $user_index, $participant_data);
    if ($res['status'] == 'error') {
        wp_send_json_error($res);
    }
    wp_send_json_success($res);
}
add_action('wp_ajax_save_participant_data', 'save_participant_data_handler');