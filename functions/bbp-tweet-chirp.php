<?php

    // require_once($_SERVER['DOCUMENT_ROOT'].'/project-6854156-avoleoo-hashtag-wizard-wordpress-plugin/wp-load.php' );
    //
    // require_once( $_SERVER['DOCUMENT_ROOT'].'/project-6854156-avoleoo-hashtag-wizard-wordpress-plugin/wp-content/plugins/hashtag-wizard/functions/twitter-api.php' );


    // Function for parsing an object to an array
    function object_to_array($data) {
        if (is_array($data) || is_object($data)) {
            $result = array();
            foreach ($data as $key => $value) {
                $result[$key] = object_to_array($value);
            }
            return $result;
        }
        return $data;
    }



    $retweetTable = $wpdb->prefix . 'hashtag_retweet_settings';
    $favouriteTable = $wpdb->prefix . 'hashtag_favourite_settings';
    $replyTable = $wpdb->prefix . 'hashtag_reply_settings';


    $oAuthTable = $wpdb->prefix . 'hashtag_oauth_settings';
    $oAuth = $wpdb->get_results("SELECT * FROM $oAuthTable", ARRAY_A);



// ----- SCHEDULING RETWEETS

    $query = "SELECT * FROM $retweetTable";
    $retweets = $wpdb->get_results( $query, 'ARRAY_A' );


    foreach ( $retweets as $key => $retweet ) {

        if ( $retweet['hashtag_admin_retweet_frequency'] != 0 ) {

            $hashtags = explode( ',', $retweet['hashtag_admin_retweet_hashtags'] );

            $accounts = explode( ',', $retweet['hashtag_admin_retweet_accounts'] );

            foreach ( $hashtags as $key => $hashtag ) {

                if ( $retweet['hashtag_admin_retweet_random'] == 1 ) {

                    $account = $accounts[array_rand( $accounts )];

                } else {

                    $account = $accounts[array_rand( $accounts )];

                }


                // Adding oAuth credentials

                foreach ( $oAuth as $key => $value ) {

                    if ( in_array( $account, $value ) ) {

                        $settings = array(
                            'oauth_access_token' => $value['hashtag_oauth_access_token'],
                            'oauth_access_token_secret' => $value['hashtag_oauth_access_token_secret'],
                            'consumer_key' => $value['hashtag_oauth_consumer_key'],
                            'consumer_secret' => $value['hashtag_oauth_consumer_secret']
                        );

                    }

                }

                $url = 'https://api.twitter.com/1.1/search/tweets.json';

                $requestMethod = 'GET';
                $twitter = new TwitterAPIExchange( $settings );

                $tag = $hashtag;
                $lastTweet = $retweet['hashtag_admin_retweet_last_tweet'];
                $q = '#' . $tag;
                $count = $retweet['hashtag_admin_retweet_throttling'];

                if ( ! $lastTweet || $lastTweet == '' ) {
                    $since_id = 0;
                } else {
                    $since_id = $lastTweet;
                }

                $result_type = 'mixed';
                $api = 'search_tweets';

                $getfield = '?q=' . $q . '&since_id=' . $since_id . '&count=' . $count . '&result_type=' . $result_type;

                $tweets = $twitter->setGetfield( $getfield )
                ->buildOauth( $url, $requestMethod )
                ->performRequest();


                $tweets = object_to_array( json_decode( $tweets ) );

                foreach ( $tweets as $key => $tweet ) {

                    foreach ( $tweet as $key => $value ) {
                        echo $value['id'] . "\n";

                        // Retweeting the tweet
                        $retweetUrl = 'https://api.twitter.com/1.1/statuses/retweet/' . $value['id'] . '.json';
                        $postfields = array('id' => $value['id']);
                        $requestMethod = 'POST';

                        $twitter = new TwitterAPIExchange( $settings );
                        $response =  $twitter->buildOauth( $retweetUrl, $requestMethod )
                        ->setPostfields( $postfields )
                        ->performRequest();
                        var_dump( json_decode( $response ) );



                        // Updating database with last id used
                        $wpdb->update(
                            $retweetTable,
                            array(
                                'hashtag_admin_retweet_last_tweet' => $value['id']		// Update
                            ),
                            array(
                                'hashtag_admin_retweet_id' => $retweet['hashtag_admin_retweet_id']	// Where
                            )
                        );



                    }

                }

                unset( $settings );
                unset( $tweets );

            }

            unset( $accounts );
            unset( $hashtags );
        }
    }

// ----- //SCHEDULING RETWEETS







// ----- SCHEDULING FAVOURITES

    $query = "SELECT * FROM $favouriteTable";
    $favourites = $wpdb->get_results( $query, 'ARRAY_A' );

    foreach ( $favourites as $key => $retweet ) {

        if ( $retweet['hashtag_admin_favourite_frequency'] != 0 ) {

            $hashtags = explode( ',', $retweet['hashtag_admin_favourite_hashtags'] );

            $accounts = explode( ',', $retweet['hashtag_admin_favourite_accounts'] );

            foreach ( $hashtags as $key => $hashtag ) {

                if ( $retweet['hashtag_admin_favourite_random'] == 1 ) {

                    $account = $accounts[array_rand( $accounts )];

                } else {

                    $account = $accounts[0];

                }


                // Adding oAuth credentials

                foreach ( $oAuth as $key => $value ) {

                    if ( in_array( $account, $value ) ) {

                        $settings = array(
                            'oauth_access_token' => $value['hashtag_oauth_access_token'],
                            'oauth_access_token_secret' => $value['hashtag_oauth_access_token_secret'],
                            'consumer_key' => $value['hashtag_oauth_consumer_key'],
                            'consumer_secret' => $value['hashtag_oauth_consumer_secret']
                        );

                    }

                }

                $url = 'https://api.twitter.com/1.1/search/tweets.json';

                $requestMethod = 'GET';
                $twitter = new TwitterAPIExchange( $settings );

                $tag = $hashtag;
                $lastTweet = $retweet['hashtag_admin_favourite_last_tweet'];
                $q = '#' . $tag;
                $count = $retweet['hashtag_admin_favourite_throttling'];

                if ( ! $lastTweet || $lastTweet == '' ) {
                    $since_id = 0;
                } else {
                    $since_id = $lastTweet;
                }

                $result_type = 'mixed';
                $api = 'search_tweets';

                $getfield = '?q=' . $q . '&since_id=' . $since_id . '&count=' . $count . '&result_type=' . $result_type;

                $tweets = $twitter->setGetfield( $getfield )
                ->buildOauth( $url, $requestMethod )
                ->performRequest();


                $tweets = object_to_array( json_decode( $tweets ) );

                foreach ( $tweets as $key => $tweet ) {

                    foreach ( $tweet as $key => $value ) {
                        echo $value['id'] . "\n";

                        // Favouriting the tweet
                        $retweetUrl = 'https://api.twitter.com/1.1/favorites/create.json';
                        $postfields = array('id' => $value['id']);
                        $requestMethod = 'POST';

                        $twitter = new TwitterAPIExchange( $settings );
                        $response =  $twitter->buildOauth( $retweetUrl, $requestMethod )
                        ->setPostfields( $postfields )
                        ->performRequest();
                        var_dump( json_decode( $response ) );


                        // Updating database with last id used
                        $wpdb->update(
                        $favouriteTable,
                        array(
                                'hashtag_admin_favourite_last_tweet' => $value['id']		// Update
                            ),
                            array(
                                'hashtag_admin_favourite_id' => $retweet['hashtag_admin_favourite_id']	// Where
                            )
                        );

                    }

                }

                unset( $settings );
                unset( $tweets );

            }

            unset( $accounts );
            unset( $hashtags );
        }
    }

// ----- //SCHEDULING FAVOURITES



// ----- SCHEDULING REPLIES

    $query = "SELECT * FROM $replyTable";
    $replies = $wpdb->get_results( $query, 'ARRAY_A' );

    foreach ( $replies as $key => $retweet ) {

        if ( $retweet['hashtag_admin_reply_frequency'] != 0 ) {

            $hashtags = explode( ',', $retweet['hashtag_admin_reply_hashtags'] );

            $accounts = explode( ',', $retweet['hashtag_admin_reply_accounts'] );

            foreach ( $hashtags as $key => $hashtag ) {

                if ( $retweet['hashtag_admin_reply_random'] == 1 ) {

                    $account = $accounts[array_rand( $accounts )];

                } else {

                    $account = $accounts[0];

                }


                // Adding oAuth credentials

                foreach ( $oAuth as $key => $value ) {

                    if ( in_array( $account, $value ) ) {

                        $settings = array(
                            'oauth_access_token' => $value['hashtag_oauth_access_token'],
                            'oauth_access_token_secret' => $value['hashtag_oauth_access_token_secret'],
                            'consumer_key' => $value['hashtag_oauth_consumer_key'],
                            'consumer_secret' => $value['hashtag_oauth_consumer_secret']
                        );

                    }

                }

                $url = 'https://api.twitter.com/1.1/search/tweets.json';

                $requestMethod = 'GET';
                $twitter = new TwitterAPIExchange( $settings );

                $tag = $hashtag;
                $lastTweet = $retweet['hashtag_admin_reply_last_tweet'];
                $q = '#' . $tag;
                $count = $retweet['hashtag_admin_reply_throttling'];

                if ( ! $lastTweet || $lastTweet == '' ) {
                    $since_id = 0;
                } else {
                    $since_id = $lastTweet;
                }

                $result_type = 'mixed';
                $api = 'search_tweets';

                $getfield = '?q=' . $q . '&since_id=' . $since_id . '&count=' . $count . '&result_type=' . $result_type;

                $tweets = $twitter->setGetfield( $getfield )
                ->buildOauth( $url, $requestMethod )
                ->performRequest();


                $tweets = object_to_array( json_decode( $tweets ) );

                foreach ( $tweets as $key => $tweet ) {

                    foreach ( $tweet as $key => $value ) {
                        echo $value['id'] . "\n";

                        // Replying to the tweet
                        $retweetUrl = 'https://api.twitter.com/1.1/statuses/update.json';
                        $postfields = array(
                            'status' => '@' . $value['user']['screen_name'] . ' ' . $retweet['hashtag_admin_reply_message'],
                            'in_reply_to_status_id' => $value['id'],
                        );

                        $requestMethod = 'POST';

                        $twitter = new TwitterAPIExchange( $settings );
                        $response =  $twitter->buildOauth( $retweetUrl, $requestMethod )
                        ->setPostfields( $postfields )
                        ->performRequest();
                        var_dump( json_decode( $response ) );


                        // Updating database with last id used
                        $wpdb->update(
                        $replyTable,
                            array(
                                'hashtag_admin_reply_last_tweet' => $value['id']		// Update
                            ),
                            array(
                                'hashtag_admin_reply_id' => $retweet['hashtag_admin_reply_id']	// Where
                            )
                        );

                    }

                }

                unset( $settings );
                unset( $tweets );

            }

            unset( $accounts );
            unset( $hashtags );
        }

    }


// ----- //SCHEDULING REPLIES




?>
