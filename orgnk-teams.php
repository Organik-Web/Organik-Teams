<?php
/*
Plugin Name:    Organik Teams
Description:    Create and manage team members
Version:        1.0.0
Author:         Organik Web
Author URI:     https://www.organikweb.com.au/
License:        GNU General Public License v2 or later
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * Current plugin version
 */
define( 'ORGNK_TEAMS_VERSION', '1.0.0' );

/**
 * Register activation hook
 * This action is documented in inc/class-activator.php
 */
function orgnk_teams_activate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-activator.php';
	Organik_Teams_Activator::activate();
}
register_activation_hook( __FILE__, 'orgnk_teams_activate_plugin' );

/**
 * Register deactivation hook
 * This action is documented in inc/class-activator.php
 */
function orgnk_teams_deactivate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-activator.php';
	Organik_Teams_Activator::deactivate();
}
register_deactivation_hook( __FILE__, 'orgnk_teams_deactivate_plugin' );

/*
 * Load dependencies
 */
require_once plugin_dir_path( __FILE__ ) . 'inc/class-cpt-teams.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/class-tax-teams-categories.php';

/**
 * Load helper functions
 */
require_once plugin_dir_path( __FILE__ ) . 'lib/helpers.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/schema.php';
require_once plugin_dir_path( __FILE__ ) . 'lib/acf-fields.php';

/**
 * Run the main instance of this plugin
 */
Organik_Teams::instance();
