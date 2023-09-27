<?php
/**
 * Plugin Name:     Google Doc to RSS
 * Description:     Create a simple RSS feed from lines in a Google Doc.
 * Author:          Jeremy Leggat
 * Version:         0.7.0
 *
 * GitHub Plugin URI: https://github.com/cronkiteschool/GDoc_To_RSS
 * Primary Branch: main
 *
 * @package         GDoc_To_RSS
 */

// Your code starts here.
class GDoc2RSS
{
    private $pluginName = "gdocrss";

    public function __construct()
    {
        // Hook into the admin menu
        add_action('admin_menu', array( $this, 'create_plugin_settings_page' ));
        add_action('admin_init', array( $this, 'setup_sections' ));
        add_action('admin_init', array( $this, 'setup_fields' ));
        add_action('init', array( $this, 'setup_rss' ));
    }

    private function create_plugin_settings_page()
    {
        // Add the menu item and page
        $page_title = 'Ticker Feed Settings Page';
        $menu_title = 'Ticker Feed Plugin';
        $capability = 'manage_options';
        $slug = 'gdoc2rss_fields';
        $callback = array( $this, 'plugin_settings_page_content' );

        add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $slug, $callback, );
    }

    private function plugin_settings_page_content()
    { ?>
	    <div class="wrap">
		<h2>Cronkite Ticker Settings Page</h2>
		<form method="post" action="options.php">
		    <?php
            settings_fields('gdoc2rss_fields');
        do_settings_sections('gdoc2rss_fields');
        submit_button();
        ?>
		</form>
	    </div> <?php
    }

    private function setup_sections()
    {
        add_settings_section('config_section', 'Configuration', array( $this, 'section_callback' ), 'gdoc2rss_fields');
    }

    private function section_callback($arguments)
    {
        switch($arguments['id']) {
            case 'config_section':
                echo 'Set to read text from a Google Doc to RSS feed for the building\'s Ticker';
                break;
            case 'test_section':
                echo 'Test reading text from a Google Doc to RSS feed';
                break;
        }
    }

    private function setup_fields()
    {
        $fields = array(
        array(
            'uid' => 'feed_name',
            'label' => 'Feed Name',
            'section' => 'config_section',
            'type' => 'text',
            'options' => false,
            'placeholder' => 'feedname',
            'helper' => 'Keep this name simple as it is used to forms your this feed URL.',
            'supplemental' => sprintf("The feed will be available at %s<em>%s</em>", site_url('/feed/'), get_option('feed_name')),
            'default' => 'ticker'
        ),
        array(
            'uid' => 'gdoc_id',
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
            add_settings_field($field['uid'], $field['label'], array( $this, 'field_callback' ), 'gdoc2rss_fields', $field['section'], $field);
            register_setting('gdoc2rss_fields', $field['uid']);
        }
    }

    private function field_callback($arguments)
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

    private function setup_rss()
    {
        add_feed(get_option('feed_name'), array( $this, 'rss_callback' ));
    }

    private function rss_callback()
    {
        $body     = $this->fetch_gdoc_text();
        include_once(plugin_dir_path(__FILE__) . 'rss-text-lines.php');
    }

    private function fetch_gdoc_text()
    {
        $url = sprintf("https://docs.google.com/document/d/%s/export?format=txt", get_option('gdoc_id'));
        $response = wp_safe_remote_get($url);
        $body     = wp_remote_retrieve_body($response);
        $body     = trim($body, "\xEF\xBB\xBF"); //remove hidden utf characters

        return sanitize_textarea_field($body);
    }

}

// Create a new gdoc2rss instance
new GDoc2RSS();
