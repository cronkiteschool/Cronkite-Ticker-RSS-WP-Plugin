<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://asudev.jira.com/jira/software/c/projects/CSIT/pages
 * @since      2.0.0
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.0.0
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/includes
 * @author     Jeremy Leggat <jleggat@asu.edu>
 */
class Gdoc2rss_i18n
{


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'gdoc2rss',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }



}
