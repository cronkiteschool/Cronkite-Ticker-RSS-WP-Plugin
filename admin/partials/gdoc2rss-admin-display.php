<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://asudev.jira.com/jira/software/c/projects/CSIT/pages
 * @since      2.0.0
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/admin/partials
 */
?>
	<div class="wrap">
		<h2><?php $page_title ?></h2>
		<form method="post" action="options.php">
<?php
settings_fields($this->plugin_name);
do_settings_sections($this->plugin_name);
submit_button();
?>
		</form>
	</div>
