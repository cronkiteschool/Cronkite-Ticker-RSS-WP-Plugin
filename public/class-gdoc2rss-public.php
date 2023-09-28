<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://asu.edu
 * @since      1.0.0
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/public
 * @author     Jeremy Leggat <jleggat@asu.edu>
 */
class Gdoc2rss_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Gdoc2rss_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Gdoc2rss_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/gdoc2rss-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Gdoc2rss_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Gdoc2rss_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/gdoc2rss-public.js', array( 'jquery' ), $this->version, false);

    }

    public function add_rss_feed()
    {
        add_feed(get_option('feed_name'), array( $this, 'rss_callback' ));
    }

    public function rss_callback()
    {
        include_once(plugin_dir_path(__FILE__) . 'rss-text-lines.php');
    }

    public function fetch_gdoc_text()
    {
        $url = sprintf("https://docs.google.com/document/d/%s/export?format=txt", get_option('gdoc_id'));
        $response = wp_safe_remote_get($url);
        $body     = wp_remote_retrieve_body($response);
        $body     = trim($body, "\xEF\xBB\xBF"); //remove hidden utf characters

        return sanitize_textarea_field($body);
    }

}
