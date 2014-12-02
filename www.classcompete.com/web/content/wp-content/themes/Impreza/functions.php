<?php
/**
 * Include all needed files
 */
/* Slightly Modified Options Framework */
require_once('admin/index.php');
/* Admin specific functions */
require_once('functions/admin.php');
/* Load shortcodes */
require_once('functions/shortcodes.php');
require_once('functions/zilla-shortcodes/zilla-shortcodes.php');
/* Breadcrumbs function */
require_once('functions/breadcrumbs.php');
/* Post formats */
require_once('functions/post_formats.php');
/* Custom Post types */
require_once('functions/post_types.php');
/* Meta Box plugin and settings */
define('RWMB_URL', trailingslashit(get_template_directory_uri() . '/vendor/meta-box'));
define('RWMB_DIR', trailingslashit(get_template_directory() . '/vendor/meta-box'));
require_once RWMB_DIR . 'meta-box.php';
require_once('functions/meta-box_settings.php');
/* Menu and it's custom markup */
require_once('functions/menu.php');
/* Comments custom markup */
require_once('functions/comments.php');
/* wp_link_pages both next and numbers usage */
require_once('functions/link_pages.php');
/* Sidebars init */
require_once('functions/sidebars.php');
/* Sidebar generator */
require_once('vendor/sidebar_generator.php');
/* Plugins activation */
require_once('functions/plugin_activation.php');
/* CSS and JS enqueue */
require_once('functions/enqueue.php');
/* Widgets */
require_once('functions/widgets/contact.php');
require_once('functions/widgets/socials.php');
add_filter('widget_text', 'do_shortcode');
/* Auto Updater */
require_once('vendor/tf_updater/index.php');

require_once('functions/ajax_grid_blog.php');
require_once('functions/ajax_import.php');

/* WooCommerce */
require_once('functions/woocommerce.php');
/* bbPress */
require_once('functions/bbpress.php');

/**
 * Theme Setup
 */
function us_theme_setup()
{
    global $smof_data, $content_width;

    if (!isset($content_width)) $content_width = 1500;
    add_theme_support('automatic-feed-links');

    add_theme_support('post-formats', array('quote', 'image', 'gallery', 'video',));

    /* Add post thumbnail functionality */
    add_theme_support('post-thumbnails');
    add_image_size('portfolio-list', 570, 380, true);
    add_image_size('portfolio-list-3-2', 570, 380, true);
    add_image_size('portfolio-list-4-3', 570, 428, true);
    add_image_size('portfolio-list-1-1', 570, 570, true);
    add_image_size('portfolio-list-2-3', 380, 570, true);
    add_image_size('portfolio-list-3-4', 428, 570, true);
    add_image_size('blog-small', 350, 350, true);
    add_image_size('blog-grid', 500, 0, false);
    add_image_size('blog-large', 1140, 600, true);
    add_image_size('carousel-thumb', 200, 133, false);
    add_image_size('gallery-xs', 114, 114, true);
    add_image_size('gallery-s', 190, 190, true);
    add_image_size('gallery-m', 228, 228, true);
    add_image_size('gallery-l', 285, 285, true);
    add_image_size('gallery-masonry', 500, 0, false);
    add_image_size('member', 350, 350, true);


    /* hide admin bar */
//	show_admin_bar( false );

    /* Excerpt length */
    if (isset($smof_data['blog_excerpt_length']) AND $smof_data['blog_excerpt_length'] != 55) {
        add_filter('excerpt_length', 'us_excerpt_length', 999);
    }

    /* Remove [...] from excerpt */
    add_filter('excerpt_more', 'us_excerpt_more');

    /* Theme localization */
    load_theme_textdomain('us', get_template_directory() . '/languages');
}

add_action('after_setup_theme', 'us_theme_setup');

if (!class_exists('WPBakeryVisualComposerAbstract')) {
    $dir = dirname(__FILE__) . '/wpbakery/';
    $composer_settings = Array(
        'APP_ROOT' => $dir . '/js_composer/',
        'WP_ROOT' => dirname(dirname(dirname(dirname($dir)))) . '/',
        'APP_DIR' => basename($dir) . '/js_composer/',
        'CONFIG' => $dir . '/js_composer/config/',
        'ASSETS_DIR' => 'assets/',
        'COMPOSER' => $dir . '/js_composer/composer/',
        'COMPOSER_LIB' => $dir . '/js_composer/composer/lib/',
        'SHORTCODES_LIB' => $dir . '/js_composer/composer/lib/shortcodes/',
        'USER_DIR_NAME' => 'vc_templates', /* Path relative to your current theme, where VC should look for new shortcode templates */

        //for which content types Visual Composer should be enabled by default
        'default_post_types' => Array('page', 'us_portfolio', 'post'),
    );
    require_once(get_template_directory() . '/wpbakery/js_composer/js_composer.php');
    $wpVC_setup->init($composer_settings);

    vc_disable_frontend();
}

function us_excerpt_length($length)
{
    global $smof_data;
    return $smof_data['blog_excerpt_length'];
}

function us_excerpt_more($more)
{
    return '...';
}

/* Custom code goes below this line. */

add_action('woocommerce_payment_complete', 'notifyCCParentApp');
function notifyCCParentApp($order_id)
{
// get order data
    $order = new WC_Order($order_id);
    $orderID = $order->id;
    $quantity = $order->get_item_count();
    $classes = $order->get_items();

    $rawPassword = $_POST['billing_first_name'] . $_POST['billing_last_name'];
    $rawPassword = str_replace(' ', '', $rawPassword);
    $rawPassword = strtolower($rawPassword);
    $rawPassword = $rawPassword . rand(11, 99);
    $parentData = array(
        'firstName' => $_POST['billing_first_name'],
        'lastName' => $_POST['billing_last_name'],
        'email' => $_POST['billing_email'],
        'username' => $_POST['billing_email'],
        'country' => $_POST['billing_country'],
        'password' => $rawPassword,
        'postalCode' => $_POST['billing_postcode'],
    );
    $classData = array();
    foreach ($classes as $class) {
        $productId = $class['product_id'];
        $single = array(
            'name' => $class['name'],
            'product_id' => $productId,
            'quantity' => $class['qty'],
            'code' => get_post_meta($productId, 'cc_class_code', true),
        );
        $classData[] = $single;
    }

    $url = 'http://ccapi.classcompete.com/v2/registration/wp';
    //open connection
    $parentJsonRequest = json_encode($parentData);
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($parentJsonRequest))
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parentJsonRequest);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //execute post
    $parentResult = curl_exec($ch);

    //close connection
    curl_close($ch);

    $parentCommentData = array(
        'comment_post_ID' => $order_id,
        'comment_author' => 'ParentApp Curl',
        'comment_author_email' => '',
        'comment_author_url' => $url,
        'comment_content' => '<strong>Request</strong><br/>' . $parentJsonRequest . '<br/><strong>Response</strong><br/>' . $parentResult,
        'comment_type' => 'order_note',
        'comment_parent' => 0,
        'user_id' => 0,
        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
        'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
        'comment_date' => date("Y-m-d H:i:s"),
        'comment_approved' => 1,
    );

    wp_insert_comment($parentCommentData);

    $parentData = json_decode($parentResult);

    $classPostData = array(
        'parent_id' => $parentData->id,
        'classes' => $classData,
    );

    $url = 'http://ccapi.classcompete.com/v2/class_activation/wp';
    $classPostJsonRequest = json_encode($classPostData);
    $ch = curl_init();
//set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($classPostJsonRequest))
    );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $classPostJsonRequest);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //execute post
    $classResult = curl_exec($ch);
    curl_close($ch);

    $activationCommentData = array(
        'comment_post_ID' => $order_id,
        'comment_author' => 'ParentApp Curl',
        'comment_author_email' => '',
        'comment_author_url' => $url,
        'comment_content' => '<strong>Request</strong><br/>' . $classPostJsonRequest . '<br/><strong>Response</strong><br/>' . $classResult,
        'comment_type' => 'order_note',
        'comment_parent' => 0,
        'user_id' => 0,
        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
        'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
        'comment_date' => date("Y-m-d H:i:s"),
        'comment_approved' => 1,
    );

    wp_insert_comment($activationCommentData);

//get relevant details from order
// echo '<pre>'; var_dump($classPostJsonRequest); echo '</pre>';
// echo '<pre>'; var_dump($parentData); echo '</pre>';
// echo '<pre>'; var_dump($classResult); echo '</pre>';
// die;
}

/* Custom code goes above this line. */
