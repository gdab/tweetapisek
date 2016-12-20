<?php
define('TWTPS_ADMINSLUG', 'twtps-setting');
define('TWTPS_ADMIN_GROUP', 'twtps-admin-group');

define('TWTPS_ADMIN_GROUP_GENERAL', 'twtps-admin-group-general');
define('TWTPS_ADMIN_GROUP_TWITTER_LOGIN', 'twtps-admin-group-twitter-login');
define('TWTPS_ADMIN_GROUP_TIMER', 'twtps-admin-group-timer');

define('TWTPS_ADMIN_GROUP_BASIC', 'twtps-admin-group-basic');
define('TWTPS_ADMIN_GROUP_EXCLUDEPOST', 'twtps-admin-group-excludepost');
define('TWTPS_ADMIN_GROUP_CREDITS', 'twtps-admin-group-credits' );

define('TWTPS_USER_NOTICE_KEY','twtps_user_notices_dismisses');

define('TWTPS_PHASE_STABLE','twtps-phase-stable');
define('TWTPS_PHASE_BETA','twtps-phase-beta');
define('TWTPS_PHASE_EXPERIMENTAL','twtps-phase-experimental');
define('TWTPS_PHASE_DEPRECATED','twtps-phase-deprecated');

$GLOBALS["twtps_def_user_notices_dismisses"] = array(
	"login-twitter" => false,
	"enter-gtm-code" => false,
	"wc-ga-plugin-warning" => false,
	"wc-gayoast-plugin-warning" => false,
	"wc-1-3-upgrade-info" => false
);

$GLOBAL['twtps_basicfieldtexts'] = array(
	TWTPS_OPTION_BASIC_TWEET_CONTENT => array(
		"label" => __("Tweet Content", 'tweetapisek'),
		"description" => __("What do you want to share", 'tweetapisek'),
		"phase" => TWTPS_PHASE_STABLE
	)
);
$GLOBAL['twtps_excludepostfieldtexts'] = array(
);

function twtps_sanitize_options($options){
	global $wpdb;

	//2016-12-20 TODO
}

function twtps_admin_init() {
	global $twtps_basicfieldtexts, 

	if ( isset( $_REQUEST['oauth_token'] ) ) {
		$auth_url= str_replace('oauth_token', 'oauth_token1', top_currentPageURL());
		$top_url = get_option('top_opt_admin_url') . substr($auth_url,strrpos($auth_url, "page=tweetapisek") + strlen("page=tweetapisek"));
	}

	wp_register_style( 'as-countdown-style', plugins_url('countdown/jquery.countdown.css', __FILE__) );
	wp_enqueue_style( 'as-countdown-style' );

	register_setting( TWTPS_ADMIN_GROUP, TWTPS_OPTIONS, "twtps_sanitize_options" );
	//2016-12-20 TODO
}

add_action( 'admin_init', 'twtps_admin_init' );
?>
