<?php
/**
 * Plugin Name: AdMinimal Bar
 * Description: Minimize the WordPress admin bar on the frontend to keep focus on your workflow.
 * Version: 1.0.3
 * Author: DCODED
 * Author URI: https://dcoded.dev/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Include the settings file
require_once plugin_dir_path( __FILE__ ) . 'adminimal-bar-settings.php';

// Load the AdMinimal Bar stylesheet
// Load the AdMinimal Bar JavaScript
function adminimal_bar() {
  $orientation = get_option('adminimal_bar_orientation');
  $bg_transparent = get_option('adminimal_bar_minimized_transparent');
  $logo_color = get_option('adminimal_bar_minimized_logo_color');

  if ( is_user_logged_in() && get_option('adminimal_bar_enabled') ) {
    wp_enqueue_style( 'adminimal-bar', plugins_url( 'adminimal-bar.css', __FILE__ ) );
    wp_enqueue_script( 'adminimal-bar-script', plugins_url( 'adminimal-bar.js', __FILE__ ), array( 'jquery' ), '1.0', true ); // Enqueue the JavaScript file
    add_filter( 'body_class', function( $classes ) use ( $orientation ) {
      $classes[] = "adminimal-bar-orientation-{$orientation}";
      return $classes;
    } );

    if ($bg_transparent) {
      wp_add_inline_style('adminimal-bar', "#wpadminbar:not(.active) { background: transparent; }");
      wp_add_inline_style('adminimal-bar', "#wpadminbar:not(.active) .ab-icon:before { color: $logo_color; }");
    }
  }
}
add_action( 'wp_enqueue_scripts', 'adminimal_bar' );


// Remove margin-top from html
add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

function remove_admin_login_header() {
  remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');


function adminimal_bar_add_settings_page() {
  add_options_page(
    'AdMinimal Bar Settings',
    'AdMinimal Bar',
    'manage_options',
    'adminimal-bar-settings',
    'adminimal_bar_settings'
  );
}

function adminimal_bar_settings_link($links) {
  $settings_link = '<a href="' . admin_url('options-general.php?page=adminimal-bar-settings') . '">' . __('Settings') . '</a>';
  array_unshift($links, $settings_link);
  return $links;
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'adminimal_bar_settings_link');


add_action('admin_menu', 'adminimal_bar_add_settings_page');

function adminimal_bar_uninstall() {
  // Delete the options from the database
  delete_option('adminimal_bar_enabled');
  delete_option('adminimal_bar_orientation');
  delete_option('adminimal_bar_minimized_transparent');
  delete_option('adminimal_bar_minimized_logo_color');
}

register_uninstall_hook(__FILE__, 'adminimal_bar_uninstall');

function adminimal_bar_activate() {
  // Set the default value for 'adminimal_bar_enabled' option to true
  add_option('adminimal_bar_enabled', true);
  add_option('adminimal_bar_orientation', 'horizontal');
  add_option('adminimal_bar_minimized_transparent', false);
  add_option('adminimal_bar_minimized_logo_color', '#000000');
}
register_activation_hook( __FILE__, 'adminimal_bar_activate' );
