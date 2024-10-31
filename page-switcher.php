<?php
/**
 * Plugin Name:       Page Switcher
 * Plugin URI:        http://velismichel.com/Page-Switcher.zip
 * Description:       Easily change or switch the current page to other pages from the wordpress page editor.
 * Version:           1.0.4
 * Author:            Michel Velis
 * Author URI:        http://velismichel.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       page-switcher
 */

define('PageSwitcher_CON', TRUE);

function ps_admin_styles() {
    wp_enqueue_style('select2-css', plugins_url('assets/css/select2.min.css', __FILE__));
    wp_enqueue_style('switcher-css', plugins_url('assets/css/page-switcher.css', __FILE__));
    wp_enqueue_script('select2-js', plugins_url('page-switcher/assets/js/select2.min.js', true, true, true));
}


include( plugin_dir_path( __FILE__ ) . 'admin/widgets.php');
include( plugin_dir_path( __FILE__ ) . 'admin/get_pages.php');
include( plugin_dir_path( __FILE__ ) . 'admin/get_post.php');


add_action('admin_enqueue_scripts', 'ps_admin_styles');
add_action( 'add_meta_boxes', 'page_switcher_func' );
add_action( 'add_meta_boxes', 'post_switcher_func' );

add_action('admin_notices', 'wpmamp_notice');

function wpmamp_notice() {
    global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
    if ( ! get_user_meta($user_id, 'wp_notice_mamp') ) {
        echo '<div class="wp-mamp-updated"><p>';
        printf(__('<img src="'.plugins_url('page-switcher/assets/img/mamp-logo.png').'" alt=""> <span class="text">Lighting fast Wordpress installation and development all from your localhost.</span> <a href="http://bit.ly/1PnkGfd" target="_blank" class="wpmamp-learn">Try it now!</a>   <a  class="wpmamp-hide" href="%1$s">Hide Notice</a>'), '?hide_wpmamp_notice=0');
        echo "</p></div>";
    }
}

add_action('admin_init', 'hide_wpmamp_notice');

function hide_wpmamp_notice() {
    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['hide_wpmamp_notice']) && '0' == $_GET['hide_wpmamp_notice'] ) {
             add_user_meta($user_id, 'wp_notice_mamp', 'true', true);
    }
}
