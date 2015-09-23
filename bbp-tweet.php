<?php

/*
    Plugin Name: bbp tweet
    Description: bbPress plugin to automatically tweet new topics and replies.
    Author: Jacob Ward
    Version: 1.0.0
    Author URI: http://www.jacobward.co.uk
    Plugin URI: http://www.jacobward.co.uk/bbp-tweet/
*/

$bbp_tweet_version = '1.0.0';
update_option('bbp_tweet_version', $bbp_tweet_version);

global $wpdb;
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

require_once( 'functions/twitter-api.php' ); // Including Twitter API wrapper

// Adding menu items
add_action( 'admin_menu', 'bbp_tweet_menu_actions' );

// Functions to include admin pages
function bbp_tweet_settings() {
    include( 'bbp-tweet-admin.php' );
}

// Create the instructions page, without link in main admin
function oauth_instructions() {
    include( 'oauth-instructions.php' );
}

// Function to create menu links
function bbp_tweet_menu_actions() {

    global $bbp_tweet_menu_page;
	$bbp_tweet_menu_page = add_menu_page( 'bbp tweet', 'bbp tweet', 1, 'bbp_tweet_settings_page', 'bbp_tweet_settings' );

    global $bbp_tweet_oauth_instructions_page;
    add_submenu_page( 'oauth-instructions.php', 'Twitter oAuth Instructions', 'Twitter oAuth Instructions', 'manage_options', 'oauth_instructions_page', 'oauth_instructions' );

}




add_action( 'admin_enqueue_scripts', 'bbp_tweet_admin_init' );

function bbp_tweet_admin_init( $hook ) {

    global $bbp_tweet_menu_page;

    if ( 'bbp-tweet-admin.php' != $bbp_tweet_menu_page ) {
        return;
    }

    wp_register_style( 'bbp_tweet_bootstrap_main_stylesheet', plugins_url( 'css/bootstrap.min.css', __FILE__) );
    wp_register_style( 'bbp_tweet_bootstrap_theme_stylesheet', plugins_url( 'css/bootstrap-theme.min.css', __FILE__) );
    wp_register_style( 'bbp_tweet_bootstrap_select_stylesheet', plugins_url( 'css/bootstrap-select.min.css', __FILE__) );
    wp_register_style( 'bbp_tweet_stylesheet', plugins_url( 'css/bbp-tweet.css', __FILE__) );

    wp_enqueue_style( 'bbp_tweet_bootstrap_main_stylesheet' );
    wp_enqueue_style( 'bbp_tweet_bootstrap_theme_stylesheet' );
    wp_enqueue_style( 'bbp_tweet_bootstrap_select_stylesheet' );
    wp_enqueue_style( 'bbp_tweet_stylesheet' );


    wp_register_script( 'bbp_tweet_bootstap_javascript', plugins_url( 'js/bootstrap.min.js', __FILE__) );
    wp_register_script( 'bbp_tweet_bootstap_select_javascript', plugins_url( 'js/bootstrap-select.min.js', __FILE__) );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bbp_tweet_bootstap_javascript' );
    wp_enqueue_script( 'bbp_tweet_bootstap_select_javascript' );


}


// Registering activation hook
register_activation_hook(__FILE__, 'bbp_tweet_on_activation');

// Function for creating database tables
function bbp_tweet_on_activation() {

    if ( ! class_exists( 'bbPress' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( __( 'Sorry, you need to activate bbPress first.', 'bbpress_notify') );
	}

    global $wpdb;

    // Creating table for bbp tweet settings
    $forum_settings_table = $wpdb->prefix . 'bbp_tweet_forum_settings';

    $sql_queries[] = array (
    'bbp_tweet_forum_settings_id' => "CREATE TABLE IF NOT EXISTS `$forum_settings_table` (
        `bbp_tweet_forum_settings_id` bigint(20) NOT NULL AUTO_INCREMENT,
        `bbp_tweet_forum_settings_topics` tinyint(1) COLLATE utf8_unicode_ci NOT NULL,
        `bbp_tweet_forum_settings_replies` tinyint(1) COLLATE utf8_unicode_ci NOT NULL,

        PRIMARY KEY (`bbp_tweet_forum_settings_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
        ",
    );

    // Creating table for Twitter oAuth settings
    $oauth_settings_table = $wpdb->prefix . 'bbp_tweet_oauth_settings';

    $sql_queries[] = array (
        'bbp_tweet_oauth_settings_id' => "CREATE TABLE IF NOT EXISTS `$oauth_settings_table` (
        `bbp_tweet_oauth_settings_id` bigint(20) NOT NULL AUTO_INCREMENT,
        `bbp_tweet_oauth_account_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `bbp_tweet_oauth_consumer_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `bbp_tweet_oauth_consumer_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `bbp_tweet_oauth_access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `bbp_tweet_oauth_access_token_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,

        PRIMARY KEY (`bbp_tweet_oauth_settings_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
        ",
    );

    // For each sql query in array, execute to create tables in database
    foreach ($sql_queries as $sql_query) {
        dbDelta($sql_query);
    }
}


// Function for creating a new tweet
function bbp_tweet_create_tweet( $oauth, $message ) {

    require_once( 'functions/twitter-api.php' ); // Including Twitter API wrapper

    // Retweeting the tweet - https://dev.twitter.com/rest/reference/post/statuses/update
    $tweet_url = 'https://api.twitter.com/1.1/statuses/update.json';
    $post_fields = array(
        'status' => $message
    );
    $request_method = 'POST';

    $twitter = new TwitterAPIExchange( $oauth );
    $response =  $twitter->buildOauth( $tweet_url, $request_method )
    ->setPostfields( $post_fields )
    ->performRequest();

}

function bbp_tweet_chirp( $message ) {

    global $wpdb;

    $oauth_settings_table = $wpdb->prefix . 'bbp_tweet_oauth_settings';
    $forum_settings_table = $wpdb->prefix . 'bbp_tweet_forum_settings';

    $oauth_settings_results = $wpdb->get_results( "SELECT * FROM $oauth_settings_table", ARRAY_A );
    $bbp_tweet_topics_results = $wpdb->get_results( "SELECT bbp_tweet_forum_settings_topics FROM $forum_settings_table WHERE bbp_tweet_forum_settings_id = 1", ARRAY_A );


    $bbp_tweet_oauth_consumer_key = stripslashes( filter_var( $oauth_settings_results[0]['bbp_tweet_oauth_consumer_key'], FILTER_SANITIZE_STRING ) );
    $bbp_tweet_oauth_consumer_secret = stripslashes( filter_var( $oauth_settings_results[0]['bbp_tweet_oauth_consumer_secret'], FILTER_SANITIZE_STRING ) );
    $bbp_tweet_oauth_access_token = stripslashes( filter_var( $oauth_settings_results[0]['bbp_tweet_oauth_access_token'], FILTER_SANITIZE_STRING ) );
    $bbp_tweet_oauth_access_token_secret = stripslashes( filter_var( $oauth_settings_results[0]['bbp_tweet_oauth_access_token_secret'], FILTER_SANITIZE_STRING ) );

    $oauth = array(
        'oauth_access_token' => $bbp_tweet_oauth_access_token,
        'oauth_access_token_secret' => $bbp_tweet_oauth_access_token_secret,
        'consumer_key' => $bbp_tweet_oauth_consumer_key,
        'consumer_secret' => $bbp_tweet_oauth_consumer_secret,
    );

    $bbp_tweet_create_tweet = bbp_tweet_create_tweet( $oauth, $message );

}


add_action( 'bbp_new_topic', 'bbp_tweet_new_topic' );   // Tweeting new topic
add_action( 'bbp_new_reply', 'bbp_tweet_new_reply' );   // Tweeting new reply

// Function for tweeting new topics
function bbp_tweet_new_topic( $topic_id, $forum_id, $anonymous_data, $topic_author ) {

    global $wpdb;

    $forum_settings_table = $wpdb->prefix . 'bbp_tweet_forum_settings';

    $bbp_tweet_topics_results = $wpdb->get_results( "SELECT bbp_tweet_forum_settings_topics FROM $forum_settings_table WHERE bbp_tweet_forum_settings_id = 1", ARRAY_A );

    $bbp_tweet_topics = $bbp_tweet_topics_results[0]['bbp_tweet_forum_settings_topics'];

    if ( $bbp_tweet_topics == true ) {

        $topic_title = html_entity_decode( strip_tags( bbp_get_topic_title( $topic_id ) ), ENT_NOQUOTES, 'UTF-8' );
        $topic_url = bbp_get_topic_permalink( $topic_id );

        $message = 'New Topic: ' . $topic_title . ' ' . $topic_url;

        $bbp_tweet_topic_tweeted = bbp_tweet_chirp( $message );
    }

}

// Function for tweeting new replies
function bbp_tweet_new_reply( $reply_id, $topic_id, $forum_id, $anonymous_data, $reply_author ) {

    global $wpdb;

    $forum_settings_table = $wpdb->prefix . 'bbp_tweet_forum_settings';

    $bbp_tweet_replies_results = $wpdb->get_results( "SELECT bbp_tweet_forum_settings_replies FROM $forum_settings_table WHERE bbp_tweet_forum_settings_id = 1", ARRAY_A );

    $bbp_tweet_replies = $bbp_tweet_replies_results[0]['bbp_tweet_forum_settings_replies'];

    if ( $bbp_tweet_replies == true ) {

        $topic_title = html_entity_decode( strip_tags( bbp_get_topic_title( $topic_id ) ), ENT_NOQUOTES, 'UTF-8' );
        $topic_author = bbp_get_topic_author( $topic_id );
        $topic_url = bbp_get_topic_permalink( $topic_id );

        $message = 'New Reply to ' . $topic_title . ' by ' . $topic_author . ' ' . $topic_url;

        $bbp_tweet_reply_tweeted = bbp_tweet_chirp( $message );
    }

}
