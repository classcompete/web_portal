<?php
/**
 *   Plugin Name: Classcompete marketplace plugin
 *
 *   Description: Classcompete marketplace plugin
 *   Author: CodeAnvil
 *   Version 1.0
 *   Author URI: http://www.codeanvil.co
 *
 */

define('CC_MARKETPLACE_PLUGIN_PATH', dirname(__FILE__) . '/');


require_once CC_MARKETPLACE_PLUGIN_PATH . 'functions.php';

/**
 * @param int $grade 1-8 for now - grade level
 * @param int $id challenge ID - used to get single challenge info
 * @return mixed object
 */
function get_marketplace_list($grade = null, $id = null)
{
    $api_base_url = 'http://wpapi.classcompete.com/marketplace';

    if (isset($grade) === true && empty($grade) === false) {
        $api_base_url .= '?grade=' . $grade;
    } else if (isset($id) === true && empty($id) === false) {
        $api_base_url .= '/' . $id;
    }

    $ch = curl_init($api_base_url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $content = json_decode($response);

    return $content;
}

/**
 * registers wordpress shortcode for cc marketplace functions
 */
function register_shortcodes()
{
    add_shortcode('cc_marketplace', 'cc_marketplace_shortcode');
}

// initialize custom shortcode
add_action('init', 'register_shortcodes');

/**
 * Do some style registration in WP-way
 */
function register_styles()
{
    $plugin_url = plugin_dir_url(__FILE__);

    wp_register_style('cc_marketplace_style', $plugin_url . 'assets/css/main.css');
    wp_enqueue_style('cc_marketplace_style');
}

add_action('init', 'register_styles');