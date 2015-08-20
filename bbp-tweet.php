<?php

/*
    Plugin Name: bbp tweet
    Description: bbPress plugin that tweets new topics and replies.
    Author: Jacob Ward
    Version: 1.0.0
    Author URI: http://www.jacobward.co.uk
    Plugin URI: http://www.jacobward.co.uk/bbp-tweet/
*/


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
    add_menu_page( 'bbp tweet', 'bbp tweet', 1, 'bbp_tweet_settings_page', 'bbp_tweet_settings' );

    add_submenu_page( 'oauth-instructions.php', 'Twitter oAuth Instructions', 'Twitter oAuth Instructions', 'manage_options', 'oauth_instructions_page', 'oauth_instructions' );
}




add_action( 'admin_init', 'bbp_tweet_admin_init' );

function bbp_tweet_admin_init() {

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
    wp_register_script( 'bbp_tweet_javascript', plugins_url( 'js/bbp-tweet.js', __FILE__) );

    wp_enqueue_script( 'bbp_tweet_bootstap_javascript' );
    wp_enqueue_script( 'bbp_tweet_bootstap_select_javascript' );
    wp_enqueue_script( 'bbp_tweet_javascript' );
    wp_enqueue_script( 'jquery' );


}


// Registering activation hooks
register_activation_hook(__FILE__, 'create_database_tables');	// Creating database tables on plugin load

// Function for creating database tables
function create_database_tables() {

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


add_action( 'bbp_new_topic', 'tweet_new_topic' ) );   // Tweeting new topic
add_action( 'bbp_new_reply', 'tweet_new_reply' ) );   // Tweeting new reply

// Function for tweeting new topics
function tweet_new_reply( $topic_id, $forum_id, $anonymous_data, $topic_author ) {

    global $wpdb;

    require_once( 'functions/twitter-api.php' );
    require_once( 'functions/bbp-tweet-chirp.php' );

}

// Function for tweeting new replies
function tweet_new_reply( $reply_id, $topic_id, $forum_id, $anonymous_data, $reply_author ) {

    global $wpdb;

    require_once( 'functions/twitter-api.php' );
    require_once( 'functions/bbp-tweet-chirp.php' );

}
