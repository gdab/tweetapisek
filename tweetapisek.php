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

define('TWTPS_VERSION', '0.1');
define('TWTPS_PATH',plugin_dir_path(__FILE__));

$twtps_plugin_url = plugin_dir_url(__FILE__);
$twtps_plugin_basename = plugin_basename(__FILE__);
require_once(TWTPS_PATH."/common/readoptions.php");

$admin_url = site_url('/wp-admin/admin.php?page=tweetapisek');

define('top_opt_admin_url',$admin_url);

global $top_db_version;
$top_db_version = "1.0";

//register_activation_hook( __FILE__, 'twtps_init' );
add_action('plugin_loaded','twtps_init');

add_action('admin_menu', 'tweetapisek_admin_actions');  
add_action('admin_head', 'top_opt_head_admin');
add_action('init','top_tweet_old_post');
//add_action('admin_init','top_authorize',1);

add_filter('plugin_action_links', 'top_plugin_action_links', 10, 2);

function twtps_init() {
	load_plugin_textdomain( 'tweetapisek', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	if(is_admin()){
		require_once("twtps-admin.php");
	}
	return;
	$admin_url = site_url('/wp-admin/admin.php?page=Tweetapisek');
	add_option( 'as_number_tweet', '1', '', 'yes' ); 
	add_option( 'as_post_type', 'Post', '', 'yes' ); 
	add_option( 'next_tweet_time', '0', '', 'yes' ); 
	//update_option( 'top_opt_admin_url', $admin_url, '', 'yes' );
}


function tweetapisek_admin_actions() {  
	global $admin_url;
	add_options_page("Tweetapisek", "Tweetapisek", "manage_options", "tweetapisek", "top_admin");
	$admin_url = menu_page_url('tweetapisek',false);
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

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=Tweetapisek">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}
//echo "<link rel='stylesheet' type='text/css' href='".plugins_url('countdown/jquery.countdown.css', __FILE__)."' />";
