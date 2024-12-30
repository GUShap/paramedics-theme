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
function my_acf_json_load_point($paths) {
    // Add the custom path
    $paths[] = CHILD_THEME_DIR . '/acf-json';
    return $paths;
}

/****************************/

require CHILD_THEME_DIR . '/includes/theme-hooks.php';

/***************************/

function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}