<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://asudev.jira.com/jira/software/c/projects/CSIT/pages
 * @since             0.5.0
 * @package           Gdoc2rss
 *
 * @wordpress-plugin
 * Plugin Name:       Google Doc to RSS
 * Plugin URI:        https://asudev.jira.com/jira/software/c/projects/CSIT/pages
 * Description:       Create a simple RSS feed from lines in a Google Doc.
 * Version:           2.0.0
 * Author:            Jeremy Leggat
 * Author URI:        https://asudev.jira.com/jira/software/c/projects/CSIT/pages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gdoc2rss
 * Domain Path:       /languages
 *
 * GitHub Plugin URI: https://github.com/cronkiteschool/GDoc_To_RSS
 * Primary Branch: main
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('GDOC2RSS_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gdoc2rss-activator.php
 */
function activate_gdoc2rss()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-gdoc2rss-activator.php';
    Gdoc2rss_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gdoc2rss-deactivator.php
 */
function deactivate_gdoc2rss()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-gdoc2rss-deactivator.php';
    Gdoc2rss_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_gdoc2rss');
register_deactivation_hook(__FILE__, 'deactivate_gdoc2rss');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-gdoc2rss.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gdoc2rss()
{

    $plugin = new Gdoc2rss();
    $plugin->run();

}
run_gdoc2rss();
