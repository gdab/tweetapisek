<?php   
     /* 
     Plugin Name: Tweetapisek 
     Plugin URI: http://flymetothemoon.tk/tweetapisek-tweet-your-posts-from-wordpress/
     Description: Tweetapisek will periodically tweet a random post or page automatically to promote your content and drive traffic to your Web site! You set the time, number of tweets, and just let Tweetapisek do the rest! For questions, comments, or feature requests, contact me! <a href="http://flymetothemoon.tk/">http://flymetothemoon.tk</a>.
     Author: Theeravat Suensilpong
     Version: 0.1
     Author URI: http://flymetothemoon.tk/
    */  


require_once('top-admin.php');
require_once('top-core.php');
require_once('top-excludepost.php');

define('TWEETAPISEK_VERSION', '0.1');
define('TWEETAPISEK_PATH',plugin_dir_path(__FILE__));

$tweetapisek_plugin_url = plugin_dir_url(__FILE__);

$admin_url = site_url('/wp-admin/admin.php?page=Tweetapisek');

define('top_opt_admin_url',$admin_url);

global $top_db_version;
$top_db_version = "1.0";

define ('top_opt_1_HOUR', 60*60);
define ('top_opt_2_HOURS', 2*top_opt_1_HOUR);
define ('top_opt_4_HOURS', 4*top_opt_1_HOUR);
define ('top_opt_8_HOURS', 8*top_opt_1_HOUR);
define ('top_opt_6_HOURS', 6*top_opt_1_HOUR); 
define ('top_opt_12_HOURS', 12*top_opt_1_HOUR); 
define ('top_opt_24_HOURS', 24*top_opt_1_HOUR); 
define ('top_opt_48_HOURS', 48*top_opt_1_HOUR); 
define ('top_opt_72_HOURS', 72*top_opt_1_HOUR); 
define ('top_opt_168_HOURS', 168*top_opt_1_HOUR); 
define ('top_opt_INTERVAL', 4);
define ('top_opt_INTERVAL_SLOP', 4);
define ('top_opt_AGE_LIMIT', 0); // 120 days
define ('top_opt_MAX_AGE_LIMIT', 0); // 120 days
define ('top_opt_OMIT_CATS', "");
define('top_opt_TWEET_PREFIX',"");
define('top_opt_ADD_DATA',"false");
define('top_opt_URL_SHORTENER',"is.gd");
define('top_opt_HASHTAGS',"");

register_activation_hook( __FILE__, 'plugin_install' );
add_action( 'admin_init', 'register_mysettings' );
add_action('admin_menu', 'tweetapisek_admin_actions');  
add_action('admin_head', 'top_opt_head_admin');
add_action('init','top_tweet_old_post');
add_action('admin_init','top_authorize',1);

add_filter('plugin_action_links', 'top_plugin_action_links', 10, 2);

function plugin_install() {
	$admin_url = site_url('/wp-admin/admin.php?page=Tweetapisek');
	add_option( 'as_number_tweet', '1', '', 'yes' ); 
	add_option( 'as_post_type', 'Post', '', 'yes' ); 
	add_option( 'next_tweet_time', '0', '', 'yes' ); 
	update_option( 'top_opt_admin_url', $admin_url, '', 'yes' );
}

function register_mysettings() {
	wp_register_style( 'as-countdown-style', plugins_url('countdown/jquery.countdown.css', __FILE__) );
	wp_enqueue_style( 'as-countdown-style' );
}

function tweetapisek_admin_actions() {  
	global $admin_url;
	add_options_page("Tweetapisek", "Tweetapisek", "manage_options", "tweetapisek", "top_admin");
	$admin_url = menu_page_url('tweetapisek');
	update_option( 'top_opt_admin_url', $admin_url, '', 'yes' );
}  
// 2016-12-19 TODO: make exclude posts to tab setting page
    
        
function top_authorize(){
	if ( isset( $_REQUEST['oauth_token'] ) ) {
		$auth_url= str_replace('oauth_token', 'oauth_token1', top_currentPageURL());
		$top_url = get_option('top_opt_admin_url') . substr($auth_url,strrpos($auth_url, "page=tweetapisek") + strlen("page=tweetapisek"));
	}
}

function top_plugin_action_links($links, $file) {
    static $this_plugin;
	 global $admin_url;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' .$admin_url .">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}
//echo "<link rel='stylesheet' type='text/css' href='".plugins_url('countdown/jquery.countdown.css', __FILE__)."' />";
