<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://asu.edu
 * @since      1.0.0
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/admin/partials
 */
?>
	<div class="wrap">
		<h2><?php $page_title ?></h2>
		<form method="post" action="options.php">
		<?php
            settings_fields('gdoc2rss_fields');
do_settings_sections('gdoc2rss_fields');
submit_button();
?>
		</form>
	</div>
