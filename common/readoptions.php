<?php
// ----------------- Tweetapisek common options ----------------- //
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

define('TWTPS_OPTIONS', 'twtps-options');
define('TWTPS_OPTIONS_TWITTER_ACC', 'twitter-acc');
define('TWTPS_OPTIONS_TWITTER_PROFILE_IMG_URL', 'twitter-profile-img-url');
define('TWTPS_OPTIONS_TWITTER_OAUTH_ACCESS_TOKEN', 'twitter-oauth-access-token');

define('TWTPS_OPTION_BASIC_TWEET_CONTENT','basic-tweet-content');

$twtps_options = array();

$twtps_defaultoptions = array(
);

function twtps_reload_options() {
	global $twtps_defaultoptions;

	$storedoptions = (array) get_option( TWTPS_OPTIONS );
	if(!is_array($twtps_defaultoptions)){
		$twtps_defaultoptions = array();
	}

	return array_merge( $twtps_defaultoptions , $storedoptions);
}
?>
