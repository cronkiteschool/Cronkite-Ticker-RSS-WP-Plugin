<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://asudev.jira.com/jira/software/c/projects/CSIT/pages
 * @since      2.0.0
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/admin
 * @author     Jeremy Leggat <jleggat@asu.edu>
 */
class Gdoc2rss_Admin
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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/gdoc2rss-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/gdoc2rss-admin.js', array( 'jquery' ), $this->version, false);

    }

    public function add_menu()
    {
        // Add the menu item and page
        $page_title = 'Google Doc to RSS Settings Page';
        $menu_title = 'Google Doc to RSS';
        $capability = 'manage_options';

        add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $this->plugin_name, array( $this, 'page_settings' ));
    }

    public function page_settings()
    {
        include(plugin_dir_path(__FILE__) . 'partials/gdoc2rss-admin-display.php');
    }

    public function add_sections()
    {
        add_settings_section('config_section', 'Configuration', array( $this, 'section_callback' ), $this->plugin_name);
    }

    public function section_callback($arguments)
    {
        switch($arguments['id']) {
            case 'config_section':
                echo 'Set to read text from a Google Doc to RSS feed';
                break;
            case 'test_section':
                echo 'Test reading text from a Google Doc to RSS feed';
                break;
        }
    }

    public function add_fields()
    {
        $fields = array(
        array(
            'uid' => $this->plugin_name . '_feed_name',
            'label' => 'Feed Name',
            'section' => 'config_section',
            'type' => 'text',
            'options' => false,
            'placeholder' => 'feedname',
            'helper' => 'Keep this name simple as it is used to forms your this feed URL.',
            'supplemental' => sprintf("The feed will be available at %s<em>%s</em>", site_url('/feed/'), get_option($this->plugin_name . '_feed_name')),
            'default' => 'ticker'
        ),
        array(
            'uid' =>  $this->plugin_name . '_gdoc_id',
            'label' => 'Google Doc File ID',
            'section' => 'config_section',
            'type' => 'text',
            'options' => false,
            'placeholder' => 'documentId',
            'helper' => 'This ID is the value between the "/d/" and the "/edit" in the URL of your document.',
            'supplemental' => 'The document in your Google Drive has a URL like: https://docs.google.com/document/d/<em>documentId</em>/edit',
            'default' => ''
        )
        );
        foreach($fields as $field) {
            add_settings_field($field['uid'], $field['label'], array( $this, 'field_callback' ), $this->plugin_name, $field['section'], $field);
            register_setting($this->plugin_name, $field['uid']);
        }
    }

    public function field_callback($arguments)
    {
        $value = get_option($arguments['uid']); // Get the current value, if there is one
        if(! $value) { // If no value exists
            $value = $arguments['default']; // Set to our default
        }

        // Check which type of field we want
        switch($arguments['type']) {
            case 'text': // If it is a text field
                printf('<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value);
                break;
            case 'button': // If it is a button
                printf('<input name="%1$s" id="%1$s" type="%2$s" value="%3$s" />', $arguments['uid'], $arguments['type'], $value);
                break;
        }

        // If there is help text
        if($helper = $arguments['helper']) {
            printf('<span class="helper"> %s</span>', $helper); // Show it
        }

        // If there is supplemental text
        if($supplimental = $arguments['supplemental']) {
            printf('<p class="description">%s</p>', $supplimental); // Show it
        }
    }

}
