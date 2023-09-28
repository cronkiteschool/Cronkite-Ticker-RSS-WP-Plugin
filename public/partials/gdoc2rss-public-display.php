<?php

/**
 * Provide the RSS Feed for the plugin
 *
 * RSS2 Feed Template for displaying text lines as RSS2 feed.
 *
 * @link       https://asudev.jira.com/jira/software/c/projects/CSIT/pages
 * @since      2.0.0
 *
 * @package    Gdoc2rss
 * @subpackage Gdoc2rss/public/partials
 */

$body     = $this->fetch_gdoc_text();
define('DONOTCACHEPAGE', true);
header('Content-Type: '.feed_content_type('rss2').';charset='.get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
do_action('rss_tag_pre', 'rss2');
?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php do_action('rss2_ns'); ?>>
<channel>
	<title><?php bloginfo_rss('name'); ?> - <?php get_option($this->plugin_name . '_feed_name'); ?> - Feed</title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss('description') ?></description>
	<?php do_action('rss2_head'); ?>

	<?php
    $separator = "\r\n";
$line = strtok($body, $separator);
while ($line !== false):
    $line = sanitize_text_field($line)
    ?>
	<item>
		<description><![CDATA[<?php echo wp_filter_nohtml_kses($line) ?>]]></description>
	<?php do_action('rss2_item'); ?>
	</item>
<?php
        $line = strtok($separator);
endwhile;
?>
</channel>
</rss>
