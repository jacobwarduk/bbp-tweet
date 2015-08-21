<?php

    // Function for creating an array of the oauth data
    function create_oauth_array( $oauth ) {

        foreach ( $oauth as $key => $value ) {

            $settings = array(
                'oauth_access_token' => $value['bbp_tweet_oauth_access_token'],
                'oauth_access_token_secret' => $value['bbp_tweet_oauth_access_token_secret'],
                'oauth_consumer_key' => $value['bbp_tweet_oauth_consumer_key'],
                'oauth_consumer_secret' => $value['bbp_tweet_oauth_consumer_secret']
            );

        }

        return $settings;

    }

    // Function for creating a new tweet
    function create_tweet( $oauth, $message ) {

        // Retweeting the tweet - https://dev.twitter.com/rest/reference/post/statuses/update
        $tweet_url = 'https://api.twitter.com/1.1/statuses/update.json';
        $post_fields = array(
            'status' => $message;
        );
        $request_method = 'POST';

        $twitter = new TwitterAPIExchange( $oauth );
        $response =  $twitter->buildOauth( $tweet_url, $request_method )
        ->setPostfields( $post_fields )
        ->performRequest();
        var_dump( json_decode( $response ) );

    }


    $oauth_settings_table = $wpdb->prefix . 'bbp_tweet_oauth_settings';
    $forum_settings_table = $wpdb->prefix . 'bbp_tweet_forum_settings';

    $oauth_settings = $wpdb->get_results( "SELECT * FROM $oauth_settings_table", ARRAY_A );
    $bbp_tweet_topics = $wpdb->get_results( "SELECT `bbp_tweet_forum_settings_topics` FROM $forum_settings_table", ARRAY_A );
    $bbp_tweet_replies = $wpdb->get_results( "SELECT `bbp_tweet_forum_settings_replies` FROM $forum_settings_table", ARRAY_A );

    // Tweet new topic
    if ( ! $reply_id || $reply_id == '' || $reply_id === false ) {

        if ( $bbp_tweet_topics == true ) {

            $topic_title = html_entity_decode( strip_tags( bbp_get_topic_title( $topic_id ) ), ENT_NOQUOTES, 'UTF-8' );
            $topic_url = bbp_get_topic_permalink( $topic_id );

            $message = 'New Topic: ' . $topic_title . ' ' . $topic_url;
            $outh = create_oauth_array( $oauth_settings );
            $tweeted = create_tweet( $outh, $message );

        }

    } else {    // Tweet new reply

            $topic_title = html_entity_decode( strip_tags( bbp_get_topic_title( $topic_id ) ), ENT_NOQUOTES, 'UTF-8' );
            $topic_author = bbp_get_topic_author( $topic_id );
            $topic_url = bbp_get_topic_permalink( $topic_id );

            $message = 'New Reply to ' . $topic_title . ' by ' . $topic_author . ' ' . $topic_url;
            $outh = create_oauth_array( $oauth_settings );
            $tweeted = create_tweet( $outh, $message );

        }

    }
