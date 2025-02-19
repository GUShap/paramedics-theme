<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// BEGIN ENQUEUE PARENT ACTION

define('CHILD_THEME_DIR', get_stylesheet_directory());
define('CHILD_THEME_URI', get_stylesheet_directory_uri());
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('child_theme_configurator_css')):
    function child_theme_configurator_css()
    {
        wp_enqueue_style('chld_thm_cfg_child', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('hello-elementor', 'hello-elementor', 'hello-elementor-theme-style', 'hello-elementor-header-footer'));
    }
endif;
add_action('wp_enqueue_scripts', 'child_theme_configurator_css', 10);

// END ENQUEUE PARENT ACTION
function disable_gutenberg_editor($is_enabled, $post_type)
{
    // Disable for all post types
    return false;
}

add_filter('use_block_editor_for_post_type', 'disable_gutenberg_editor', 10, 2);

/****************************/
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point($path)
{
    // Set the save path
    $path = CHILD_THEME_DIR . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point($paths)
{
    // Add the custom path
    $paths[] = CHILD_THEME_DIR . '/acf-json';
    return $paths;
}

/****************************/

require CHILD_THEME_DIR . '/includes/theme-hooks.php';

/***************************/
function get_journey_dates($journey_id)
{
    $journey_dates = get_field('journey_dates', $journey_id) ?? [];
    $dates = [];
    foreach ($journey_dates as $date) {
        $departure_date = $date['departure_date'] ?? '';
        $return_date = $date['return_date'] ?? '';
        $is_active_registration = !empty($date['is_active_registration']);
        $is_full = !empty($date['is_full']);
        if (empty($departure_date) || has_date_passed($departure_date) || !$is_active_registration) {
            continue;
        }
        $dates[] = [
            'departure_date' => $departure_date,
            'return_date' => $return_date,
            'is_full' => $is_full
        ];
    }
    return $journey_dates;
}
/***************************/

function add_journey_participant($journey_id, $journey_date, $participant)
{
    $journey_dates = get_field('dates', $journey_id);
    $is_registered = false;
    $selected_date_idx = array_search($journey_date, array_column($journey_dates, 'departure_date'));
    $selected_date = $journey_dates[$selected_date_idx];
    $participants = gettype($selected_date['participants']) == 'string' ? json_decode($selected_date['participants']) : [];
    $res = [
        'status' => 'error',
        'message' => 'כתובת האימייל כבר רשומה למסע'
    ];

    foreach ($participants as $registered_participant) {
        if ($registered_participant->email == $participant['email']) {
            $is_registered = true;
            break;
        }
    }
    if (!$is_registered) {
        $participants[] = $participant;
        $journey_dates[$selected_date_idx]['participants'] = json_encode($participants, JSON_UNESCAPED_UNICODE);
        $res = [
            'status' => 'success',
            'message' => 'הרשמה בוצעה בהצלחה, ניצור עמך קשר בהקדם'
        ];
    }

    update_field('dates', $journey_dates, $journey_id);
    return $res;
}

function save_participant_data($post_id, $departure_date, $user_index, $participant_data)
{
    $journey_dates = get_field('dates', $post_id);
    $selected_date_idx = array_search($departure_date, array_column($journey_dates, 'departure_date'));
    $selected_date = $journey_dates[$selected_date_idx];
    $participants = gettype($selected_date['participants']) == 'string' ? json_decode($selected_date['participants']) : [];

    $participants[$user_index]->is_flexible = $participant_data['is_flexible'] == 'true';
    $participants[$user_index]->status = $participant_data['status'];
    $participants[$user_index]->contact = $participant_data['contact'];
    $journey_dates[$selected_date_idx]['participants'] = json_encode($participants, JSON_UNESCAPED_UNICODE);
    update_field('dates', $journey_dates, $post_id);
    return [
        'status' => 'success',
        'message' => 'הנתונים נשמרו בהצלחה'
    ];
}

function get_departure_participants($participants, $journey_statuses, $journey_contacts)
{
    $participants_list_template_path = CHILD_THEME_DIR . '/includes/admin/templates/participants-list.php';
    if (file_exists($participants_list_template_path)) {
        require_once $participants_list_template_path;
    }
}
/***************************/
function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function format_date_to_hebrew($date)
{
    // Array of Hebrew month names
    $hebrew_months = [
        1 => 'ינואר',
        2 => 'פברואר',
        3 => 'מרץ',
        4 => 'אפריל',
        5 => 'מאי',
        6 => 'יוני',
        7 => 'יולי',
        8 => 'אוגוסט',
        9 => 'ספטמבר',
        10 => 'אוקטובר',
        11 => 'נובמבר',
        12 => 'דצמבר'
    ];

    // Convert input date to DateTime object
    $date_object = DateTime::createFromFormat('d-m-Y', $date);

    // Extract parts of the date
    $day = $date_object->format('j');
    $month = (int) $date_object->format('n'); // Get month as an integer
    $year = $date_object->format('Y');

    // Format the date with Hebrew month
    return $hebrew_months[$month] . ' ' . $day . ', ' . $year;
}

function has_date_passed($date)
{
    // Convert input date to DateTime object
    $input_date = DateTime::createFromFormat('d-m-Y', $date);

    // Check if the date is valid
    if (!$input_date) {
        return false; // Invalid date
    }

    // Get the current date
    $current_date = new DateTime();

    // Compare the dates
    return $input_date < $current_date;
}

add_action('elementor/query/custom-team-query', function ($query) {
    $query->set('post_type', ['team']);
    $slug = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
    $term = get_term_by('slug', $slug, 'department'); // Get term by slug
    $tax_query = [
        [
            'taxonomy' => 'department',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ],
        [
            'taxonomy' => 'role',
            'field' => 'slug',
            'terms' => 'dep-head',
            'operator' => 'NOT IN'
        ],
    ];

    $query->set('tax_query', $tax_query);

});

add_action('elementor/query/custom-team-manager-query', function ($query) {
    $query->set('post_type', ['team']);
    $slug = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
    $term = get_term_by('slug', $slug, 'department'); // Get term by slug

    $tax_query = [
        'relation' => 'AND',
        [
            'taxonomy' => 'department',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ],
        [
            'taxonomy' => 'role',
            'field' => 'slug',
            'terms' => 'dep-head',
        ],
    ];

    $query->set('tax_query', $tax_query);

});

add_action('template_redirect', function () {
    $slug = basename(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));

    // dd($term);
});