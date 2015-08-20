<?php

global $wpdb;

include_once( plugins_url( 'functions/twitter-api.php', __FILE__ ) );
include_once( plugins_url( 'functions/object-to-array.php', __FILE__ ) );

$oAuthTable = $wpdb->prefix . 'hashtag_oauth_settings';
$oAuth = $wpdb->get_results("SELECT * FROM $oAuthTable", ARRAY_A);

$retweetTable = $wpdb->prefix . 'hashtag_retweet_settings';
$favouriteTable = $wpdb->prefix . 'hashtag_favourite_settings';
$replyTable = $wpdb->prefix . 'hashtag_reply_settings';


// Retweet settings form submission
if ( $_POST['retweet_form_submit'] ) {

    if ( isset( $_POST['retweet_hashtags'] ) &&  $_POST['retweet_hashtags'] != '' && isset( $_POST['retweet_accounts'] ) && $_POST['retweet_accounts'] != '' && isset( $_POST['retweet_type'] ) && $_POST['retweet_type'] != '' && isset( $_POST['retweet_throttle'] ) && $_POST['retweet_throttle'] != '' ) {

        $retweetTable = $wpdb->prefix . 'hashtag_retweet_settings';

        $retweetHashtags = stripslashes( filter_var( str_replace( '#', '', $_POST['retweet_hashtags'] ), FILTER_SANITIZE_STRING ) );

        if ( in_array( 'random',  $_POST['retweet_accounts']) ) {
            if ( ( $key = array_search( 'random', $_POST['retweet_accounts'] ) ) !== false ) {
                unset($_POST['retweet_accounts'][$key]);
            }
            $random = 1;
            unset( $_POST['retweet_accounts']['random'] );
        } else {
            $random = 0;
        }

        $retweetAccounts = stripslashes( filter_var( implode( ',', $_POST['retweet_accounts'] ), FILTER_SANITIZE_STRING ) );
        $retweetRandom = $random;
        $retweetType = stripslashes( filter_var( $_POST['retweet_type'], FILTER_SANITIZE_STRING ) );
        $retweetThrottle = stripslashes( filter_var( $_POST['retweet_throttle'], FILTER_SANITIZE_STRING ) );


        $wpdb->insert($retweetTable, array(
                'hashtag_admin_retweet_hashtags' => $retweetHashtags,
                'hashtag_admin_retweet_accounts' => $retweetAccounts,
                'hashtag_admin_retweet_random' => $retweetRandom,
                'hashtag_admin_retweet_type' => $retweetType,
                'hashtag_admin_retweet_throttling' => $retweetThrottle,
                'hashtag_admin_retweet_frequency' => 1,
            ),
            array('%s')
        );

        if ( $wpdb->insert_id != false ) {
            $success = true;
            $message = 'Successfully saved your retweet settings.';
        } else {
            $success = false;
            $error = 'There was an error saving your retweet settings. Please Try again.';
        }
    } else {
        $success = false;
        $error = 'There was an error saving your retweet settings. Please Try again.';
    }
}


// Favourite settings form submission
if ( $_POST['favourite_form_submit'] ) {

    if ( isset( $_POST['favourite_hashtags'] ) &&  $_POST['favourite_hashtags'] != '' && isset( $_POST['favourite_accounts'] ) && $_POST['favourite_accounts'] != '' && isset( $_POST['favourite_throttle'] ) && $_POST['favourite_throttle'] != '' ) {

        $favouriteTable = $wpdb->prefix . 'hashtag_favourite_settings';

        $favouriteHashtags = stripslashes( filter_var( str_replace( '#', '', $_POST['favourite_hashtags'] ), FILTER_SANITIZE_STRING ) );

        if ( in_array( 'random',  $_POST['favourite_accounts']) ) {
            if ( ( $key = array_search( 'random', $_POST['favourite_accounts'] ) ) !== false ) {
                unset($_POST['favourite_accounts'][$key]);
            }
            $random = 1;
            unset( $_POST['favourite_accounts']['random'] );
        } else {
            $random = 0;
        }

        $favouriteAccounts = stripslashes( filter_var( implode( ',', $_POST['favourite_accounts'] ), FILTER_SANITIZE_STRING ) );
        $favouriteRandom = $random;
        $favouriteThrottle = stripslashes( filter_var( $_POST['favourite_throttle'], FILTER_SANITIZE_STRING ) );

        $wpdb->insert($favouriteTable, array(
                'hashtag_admin_favourite_hashtags' => $favouriteHashtags,
                'hashtag_admin_favourite_accounts' => $favouriteAccounts,
                'hashtag_admin_favourite_random' => $favouriteRandom,
                'hashtag_admin_favourite_throttling' => $favouriteThrottle,
                'hashtag_admin_favourite_frequency' => 1,
            ),
            array('%s')
        );

        if ( $wpdb->insert_id != false ) {
            $success = true;
            $message = 'Successfully saved your favourite settings.';
        } else {
            $success = false;
            $error = 'There was an error saving your favourite settings. Please Try again.';
        }
    } else {
        $success = false;
        $error = 'There was an error saving your favourite settings. Please Try again.';
    }
}


// Reply settings form submission
if ( $_POST['reply_form_submit'] ) {

    if ( isset( $_POST['reply_hashtags'] ) &&  $_POST['reply_hashtags'] != '' && isset( $_POST['reply_accounts'] ) && $_POST['reply_accounts'] != '' && isset( $_POST['reply_throttle'] ) && $_POST['reply_throttle'] != '' ) {

        $replyTable = $wpdb->prefix . 'hashtag_reply_settings';

        $replyHashtags = stripslashes( filter_var( str_replace( '#', '', $_POST['reply_hashtags'] ), FILTER_SANITIZE_STRING ) );

        if ( in_array( 'random',  $_POST['reply_accounts']) ) {
            if ( ( $key = array_search( 'random', $_POST['reply_accounts'] ) ) !== false ) {
                unset($_POST['reply_accounts'][$key]);
            }
            $random = 1;
            unset( $_POST['reply_accounts']['random'] );
        } else {
            $random = 0;
        }

        $replyAccounts = stripslashes( filter_var( implode( ',', $_POST['reply_accounts'] ), FILTER_SANITIZE_STRING ) );
        $replyRandom = $random;
        $replyMessage = stripslashes( filter_var( $_POST['reply_message'], FILTER_SANITIZE_STRING ) );
        $replyThrottle = stripslashes( filter_var( $_POST['reply_throttle'], FILTER_SANITIZE_STRING ) );

        $wpdb->insert($replyTable, array(
                'hashtag_admin_reply_hashtags' => $replyHashtags,
                'hashtag_admin_reply_accounts' => $replyAccounts,
                'hashtag_admin_reply_random' => $replyRandom,
                'hashtag_admin_reply_message' => $replyMessage,
                'hashtag_admin_reply_throttling' => $replyThrottle,
                'hashtag_admin_reply_frequency' => 1,
            ),
            array('%s')
        );

        if ( $wpdb->insert_id != false ) {
            $success = true;
            $message = 'Successfully saved your reply settings.';
        } else {
            $success = false;
            $error = 'There was an error saving your reply settings. Please Try again.';
        }
    } else {
        $success = false;
        $error = 'There was an error saving your reply settings. Please Try again.';
    }
}


// OAuth settings form submission
if ( $_POST['oauth_settings_form_submit'] ) {

    $consumerKey = stripslashes( filter_var( $_POST['hashtag_oauth_consumer_key'], FILTER_SANITIZE_STRING ) );
    $consumerSecret = stripslashes( filter_var( $_POST['hashtag_oauth_consumer_secret'], FILTER_SANITIZE_STRING ) );
    $accessToken = stripslashes( filter_var( $_POST['hashtag_oauth_access_token'], FILTER_SANITIZE_STRING ) );
    $accessTokenSecret = stripslashes( filter_var( $_POST['hashtag_oauth_access_token_secret'], FILTER_SANITIZE_STRING ) );

    // Adding oAuth credentials
    $settings = array(
        'oauth_access_token' => $accessToken,
        'oauth_access_token_secret' => $accessTokenSecret,
        'consumer_key' => $consumerKey,
        'consumer_secret' => $consumerSecret,
    );


    $url = 'https://api.twitter.com/1.1/account/settings.json';

    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);

    $tweets = $twitter->buildOauth($url, $requestMethod)->performRequest();

    $accountData = json_decode( $tweets ) ;

    $accountName = $accountData->screen_name;  // GET ACCOUNT NAME FROM https://api.twitter.com/1.1/account/settings.json

    if ( isset( $accountName ) && $accountName != '' ) {

        //        $wpdb->query( "TRUNCATE TABLE $oAuthTable" );

        $wpdb->insert($oAuthTable, array(
                'hashtag_oauth_account_name' => $accountName,
                'hashtag_oauth_consumer_key' => $consumerKey,
                'hashtag_oauth_consumer_secret' => $consumerSecret,
                'hashtag_oauth_access_token' => $accessToken,
                'hashtag_oauth_access_token_secret' => $accessTokenSecret,
            ),
            array('%s')
        );

        if ( $wpdb->insert_id !== false ) {
            $success = true;
            $message = 'Successfully saved your oAuth credentials';
        } else {
            $success = false;
            $error = 'There was an error saving your oAuth details. Please Try again.';
        }
    } else {
        $success = false;
        $error = 'There was an error retrieving your account details. Please Try again.';
    }

}


// Deleting retweet
if ( isset( $_POST['delete_retweet_id'] ) ) {

    $retweetDeleted = $wpdb->delete( $retweetTable, array(
            'hashtag_admin_retweet_id' => $_POST['delete_retweet_id'],
        ),
        array('%s')
    );

    if ( $retweetDeleted !== false )  {
        $success = true;
        $message = 'Successfully deleted retweet: ' . $_POST['delete_retweet_id'];
    } else {
        $success = false;
        $error = 'There was an error deleting your retweet. Please Try again.';
    }

}


// Deleting favourite
if ( isset( $_POST['delete_favourite_id'] ) ) {

    $favouriteDeleted = $wpdb->delete( $favouriteTable, array(
            'hashtag_admin_favourite_id' => $_POST['delete_favourite_id'],
        ),
        array('%s')
    );

    if ( $favouriteDeleted !== false )  {
        $success = true;
        $message = 'Successfully deleted favourite: ' . $_POST['delete_favourite_id'];
    } else {
        $success = false;
        $error = 'There was an error deleting your favourite. Please Try again.';
    }

}


// Deleting reply
if ( isset( $_POST['delete_reply_id'] ) ) {

    $replyDeleted = $wpdb->delete( $replyTable, array(
            'hashtag_admin_reply_id' => $_POST['delete_reply_id'],
        ),
        array('%s')
    );

    if ( $replyDeleted !== false )  {
        $success = true;
        $message = 'Successfully deleted reply: ' . $_POST['delete_reply_id'];
    } else {
        $success = false;
        $error = 'There was an error deleting your reply. Please Try again.';
    }

}



// Deleting account
if ( isset( $_POST['delete_account_id'] ) ) {

    $accountDeleted = $wpdb->delete( $oAuthTable, array(
            'hashtag_oauth_settings_id' => $_POST['delete_account_id'],
            ),
        array('%s')
    );

    if ( $accountDeleted !== false )  {
        $success = true;
        $message = 'Successfully deleted account: ' . $_POST['delete_account_id'];
    } else {
        $success = false;
        $error = 'There was an error deleting your account. Please Try again.';
    }

}


// Pausing retweet
if ( isset( $_POST['pause_retweet_id'] ) ) {

    $retweetPaused = $wpdb->update( $retweetTable, array(
        'hashtag_admin_retweet_frequency' => $_POST['pause_retweet_frequency'],
        ),
        array(
            'hashtag_admin_retweet_id' => $_POST['pause_retweet_id'],
        ),
        array('%s')
    );

    if ( $retweetPaused !== false )  {
        $success = true;
        $message = 'Successfully updated retweet: ' . $_POST['pause_retweet_id'];
    } else {
        $success = false;
        $error = 'There was an error updating your retweet. Please Try again.';
    }

}

// Pausing favourite
if ( isset( $_POST['pause_favourite_id'] ) ) {

    $favouritePaused = $wpdb->update( $favouriteTable, array(
        'hashtag_admin_favourite_frequency' => $_POST['pause_favourite_frequency'],
        ),
        array(
            'hashtag_admin_favourite_id' => $_POST['pause_favourite_id'],
        ),
        array('%s')
    );

    if ( $favouritePaused !== false )  {
        $success = true;
        $message = 'Successfully updated favourite: ' . $_POST['pause_favourite_id'];
    } else {
        $success = false;
        $error = 'There was an error updating your favourite. Please Try again.';
    }

}

// Pausing reply
if ( isset( $_POST['pause_reply_id'] ) ) {

    $replyPaused = $wpdb->update( $replyTable, array(
        'hashtag_admin_reply_frequency' => $_POST['pause_reply_frequency'],
        ),
        array(
            'hashtag_admin_reply_id' => $_POST['pause_reply_id'],
        ),
        array('%s')
    );

    if ( $replyPaused !== false )  {
        $success = true;
        $message = 'Successfully updated reply: ' . $_POST['pause_reply_id'];
    } else {
        $success = false;
        $error = 'There was an error updating your reply. Please Try again.';
    }

}


$retweets = $wpdb->get_results("SELECT * FROM $retweetTable", ARRAY_A);
$favourites = $wpdb->get_results("SELECT * FROM $favouriteTable", ARRAY_A);
$replies = $wpdb->get_results("SELECT * FROM $replyTable", ARRAY_A);

?>





<!-- ####### START ####### -->
<div id="hashtag-wizard" style="width: 95%; background-color: #ffffff;">

    <h3 class="hashtag-header"><b>#</b>HASHTAG WIZARD</h3>

    <?php if ($success === true ) { ?>
        <div class="alert alert-success fade in" role="alert">
            <p><span class="glyphicon glyphicon-ok-sign"></span> <b>Success: </b>
                <?php echo $message; ?>
            </p>
        </div>
    <?php } else if ( $success === false ) { ?>
        <div class="alert alert-danger fade in" role="alert">
            <p><span class="glyphicon glyphicon-exclamation-sign"></span> <b>Error: </b>
                <?php if ( $error ) { echo $error; } ?>
            </p>
        </div>
    <?php } ?>



    <?php if ($oAuth[0]['hashtag_oauth_account_name'] == '' or $oAuth[0]['hashtag_oauth_consumer_key'] == '' or $oAuth[0]['hashtag_oauth_consumer_secret'] == '' or $oAuth[0]['hashtag_oauth_access_token'] == '' or $oAuth[0]['hashtag_oauth_access_token_secret'] == '') { ?>
<!-- ####### // OATH WARNING ####### -->
        <div class="alert alert-danger fade in" role="alert">
            <h4><span class="glyphicon glyphicon-exclamation-sign"></span> Authentication Error</h4>
            <p>In order for this plugin to function correctly you must setup a Twitter application and enter your OAuth credentials.</p>
            <p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#oAuthSettingsModal">Do this now</button>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#oAuthInstructionsModal">Instructions</button>
            </p>
        </div>
<!-- ####### // OATH WARNING ####### -->
    <?php } ?>


<!-- #######  MAIN PANEL ####### -->
    <div role="tabpanel">

<!-- ####### TOP NAVIGATION ####### -->
        <ul class="nav nav-tabs" role="tablist">

            <li role="presentation" class="active"><a href="#dashboard" aria-controls="dashboard" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span> Dashboard</a></li>

            <li role="presentation"><a href="#retweets" aria-controls="retweets" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-retweet"></span> Retweets</a></li>

            <li role="presentation"><a href="#favourites" aria-controls="favourites" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-star-empty"></span> Favourites</a></li>

            <li role="presentation"><a href="#replies" aria-controls="replies" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-share-alt"></span> Replies</a></li>

            <li class="divider"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>

            <li role="settings"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>

            <li class="dropdown">
                <a href="#" aria-controls="accounts" role="tab"  data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-user"></span> Accounts</a>
                <ul class="dropdown-menu">
                    <?php
                        foreach ($oAuth as $key => $value ) {
                    ?>
                        <li class="disabled"><a href="#">@<?php echo $value['hashtag_oauth_account_name']; ?></a></li>
                    <?php
                        }
                    ?>
                    <li class="divider"></li>
                    <li><a href="#" data-toggle="modal" data-target="#oAuthSettingsModal">Add account</a></li>
                    <li><a href="#accounts" aria-controls="accounts" role="tab" data-toggle="tab">Manage Accounts</a></li>
                </ul>
            </li>

        </ul>
<!-- ####### // TOP NAVIGATION ####### -->

<!-- ####### TABBED PANELS ####### -->
        <div class="tab-content">

<!-- ####### DASHBOARD PANEL ####### -->
            <div role="tabpanel" class="tab-pane active" id="dashboard">
<br />

                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading"><span class="stats"><span class="glyphicon glyphicon-tasks"></span> Activity</span></div>

                            <p style="padding: 10px;">Possible future extension?</p>
                            <?php /* <table></table> */ ?>
                        </div>
                    </div>

                    <?php /*
                    <div class="col-lg-9"></div>
                    <div class="col-lg-3">
                        <nav>
                            <ul class="pagination pagination-sm">
                                <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                                <li><a href="#" class="active">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                            </ul>
                        </nav>
                    </div>
                    */ ?>

                </div>


                <div class="row-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><span class="stats"><span class="glyphicon glyphicon-stats"></span> Stats</span></div>

                        <p style="padding: 10px;">Possible future extension?</p>
                    </div>

                </div>

            </div>
<!-- ####### // DASHBOARD PANEL ####### -->

<!-- ####### RETWEETS PANEL ####### -->
            <div role="tabpanel" class="tab-pane" id="retweets">
                <form name="retweets" action="" method="POST">
                    <br />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input type="text" class="form-control" name="retweet_hashtags" placeholder="hashtags, to, follow, in, here">
                            </div>
                        </div>
                    </div>

                    <br />


                    <div class="row">

                        <div class="col-lg-3">
                            <select class="selectpicker" data-width="100%" name="retweet_accounts[]" title="Retweet from" multiple>
                                <optgroup label="Accounts">
                                    <?php
                                    foreach ($oAuth as $key => $value ) {
                                        ?>
                                        <option value="<?php echo $value['hashtag_oauth_account_name']; ?>">@<?php echo $value['hashtag_oauth_account_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </optgroup>
                                <optgroup label="Randomise">
                                    <option value="random">Random from selected</option>
                                </optgroup>
                            </select>

                        </div>


                        <div class="col-lg-3">
                            <select class="selectpicker" data-width="100%" name="retweet_type">
                                <option value="">Reweet type</option>
                                <option value="native"><span class="glyphicon glyphicon-retweet" style="color: #3399FF;"></span> &nbsp; Native Twitter Retweet</option>
                                <option value="RT" disabled>RT <span style="color: #3399FF;">@username</span> Tweet text. </option>
                                <option value="quote" disabled>"<span style="color: #3399FF;">@username</span>: Tweet text."</option>
                                <option value="via" disabled>Tweet text. (via <span style="color: #3399FF;">@username</span>)</option>
                            </select>
                        </div>


                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-addon">Throttling: </span>
                                <input type="text" class="form-control num-input" placeholder="Max tweets" name="retweet_throttle">
                                <span class="input-group-addon">every hour</span>
                            </div>
                        </div>


                        <div class="col-lg-2">
                            <button type="submit" id="retweet_save_button" data-loading-text="Saving..." class="btn btn-primary" autocomplete="off">Save</button>

                            <button type="reset" id="retweet_cancel_button" class="btn btn-secondary" autocomplete="off">Cancel</button>
                        </div>

                    </div>

                    <br />
                    <input type="hidden" name="retweet_form_submit" value="true" />
                </form>

                <?php if ( isset( $retweets ) && $retweets != '' && is_array( $retweets ) && count( $retweets ) > 0 ) { ?>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading"><span class="retweets"><span class="glyphicon glyphicon-retweet"></span>  Retweets</span></div>

                                <table class="table" data-toggle="table" data-height="299">

                                    <tr>
                                        <th># ID</th>
                                        <th>Hashtags</th>
                                        <th>Accounts</th>
                                        <th>Random</th>
                                        <th>Type</th>
                                        <th>Throttling (p/min)</th>
                                        <th>Manage</th>
                                    </tr>

                                    <?php foreach ( $retweets as $key => $retweet ) { ?>

                                        <tr>
                                            <td>
                                                <?php echo $retweet['hashtag_admin_retweet_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $retweet['hashtag_admin_retweet_hashtags']; ?>
                                            </td>
                                            <td>
                                                <?php echo $retweet['hashtag_admin_retweet_accounts']; ?>
                                            </td>
                                            <td>
                                                <?php if ( $retweet['hashtag_admin_retweet_random'] == 1 ) { echo 'Yes'; } else { echo 'No'; } ?>
                                            </td>
                                            <td>
                                                <?php echo $retweet['hashtag_admin_retweet_type']; ?>
                                            </td>
                                            <td>
                                                <?php echo $retweet['hashtag_admin_retweet_throttling']; ?>
                                            </td>
                                            <td>
                                                <form name="pause_retweet" action="" method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="pause_retweet_id" value="<?php echo $retweet['hashtag_admin_retweet_id']; ?>" />
                                                    <?php if ( $retweet['hashtag_admin_retweet_frequency'] == 1 ) { ?>
                                                        <input type="hidden" name="pause_retweet_frequency" value="0" />
                                                        <button class="btn btn-warning btn-xs" type="submit">Pause</button>
                                                    <?php } else { ?>
                                                        <input type="hidden" name="pause_retweet_frequency" value="1" />
                                                        <button class="btn btn-success btn-xs" type="submit">Start</button>
                                                    <?php } ?>
                                                </form>
                                                <form name="delete_retweet" action="" method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="delete_retweet_id" value="<?php echo $retweet['hashtag_admin_retweet_id']; ?>" />
                                                    <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </table>

                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
<!-- // ####### RETWEETS PANEL ####### -->

<!-- ####### FAVOURITES PANEL ####### -->
                <div role="tabpanel" class="tab-pane" id="favourites">
                    <form name="favourite" action="" method="POST">
                        <br />

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-addon">#</span>
                                    <input type="text" class="form-control" name="favourite_hashtags" placeholder="hashtags, to, follow, in, here">
                                </div>
                            </div>
                        </div>

                        <br />


                        <div class="row">

                            <div class="col-lg-3">
                                <select class="selectpicker" data-width="100%" name="favourite_accounts[]" title="Favourite from" multiple>
                                    <optgroup label="Accounts">
                                        <?php
                                        foreach ($oAuth as $key => $value ) {
                                            ?>
                                            <option value="<?php echo $value['hashtag_oauth_account_name']; ?>">@<?php echo $value['hashtag_oauth_account_name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </optgroup>
                                    <optgroup label="Randomise">
                                        <option value="random">Random from selected</option>
                                    </optgroup>
                                </select>

                            </div>


                            <div class="col-lg-3">

                            </div>


                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Throttling: </span>
                                    <input type="text" class="form-control num-input" placeholder="Max favourites" name="favourite_throttle">
                                    <span class="input-group-addon">every hour</span>
                                </div>
                            </div>


                            <div class="col-lg-2">
                                <button type="submit" id="favourite_save" data-loading-text="Saving..." class="btn btn-primary" autocomplete="off">Save</button>

                                <button type="reset" id="favourite_cancel" class="btn btn-secondary" autocomplete="off">Cancel</button>
                            </div>

                        </div>

                        <br />
                        <input type="hidden" name="favourite_form_submit" value="true" />
                    </form>
                    <?php if ( isset( $favourites ) && $favourites != '' && is_array( $favourites ) && count( $favourites ) > 0 ) { ?>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="panel panel-default">
                                    <div class="panel-heading"><span class="retweets"><span class="glyphicon glyphicon-star-empty"></span>  Favourites</span></div>

                                    <table class="table" data-toggle="table" data-height="299">

                                        <tr>
                                            <th># ID</th>
                                            <th>Hashtags</th>
                                            <th>Accounts</th>
                                            <th>Random</th>
                                            <th>Throttling (p/min)</th>
                                            <th>Manage</th>
                                        </tr>

                                        <?php foreach ( $favourites as $key => $favourite ) { ?>

                                            <tr>
                                                <td>
                                                    <?php echo $favourite['hashtag_admin_favourite_id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $favourite['hashtag_admin_favourite_hashtags']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $favourite['hashtag_admin_favourite_accounts']; ?>
                                                </td>
                                                <td>
                                                    <?php if ( $favourite['hashtag_admin_favourite_random'] == 1 ) { echo 'Yes'; } else { echo 'No'; } ?>
                                                </td>
                                                <td>
                                                    <?php echo $favourite['hashtag_admin_favourite_throttling']; ?>
                                                </td>
                                                <td>
                                                    <form name="pause_favourite" action="" method="POST" style="display: inline-block;">
                                                        <input type="hidden" name="pause_favourite_id" value="<?php echo $favourite['hashtag_admin_favourite_id']; ?>" />
                                                        <?php if ( $favourite['hashtag_admin_favourite_frequency'] == 1 ) { ?>
                                                            <input type="hidden" name="pause_favourite_frequency" value="0" />
                                                            <button class="btn btn-warning btn-xs" type="submit">Pause</button>
                                                            <?php } else { ?>
                                                                <input type="hidden" name="pause_favourite_frequency" value="1" />
                                                                <button class="btn btn-success btn-xs" type="submit">Start</button>
                                                                <?php } ?>
                                                            </form>
                                                    <form name="delete_favourite" action="" method="POST" style="display: inline-block;">
                                                        <input type="hidden" name="delete_favourite_id" value="<?php echo $favourite['hashtag_admin_favourite_id']; ?>" />
                                                        <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </table>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
    <!-- // ####### FAVOURITES PANEL ####### -->

    <!-- ####### REPLIES PANEL ####### -->
                <div role="tabpanel" class="tab-pane" id="replies">
                    <form name="reply" action="" method="POST">
                    <br />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon"># </span>
                                <input type="text" class="form-control" name="reply_hashtags" placeholder="hashtags, to, follow, in, here">
                            </div>
                        </div>
                    </div>

                    <br />

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-comment"></span></span>
                                <input type="text" class="form-control" name="reply_message" placeholder="Message">
                            </div>
                        </div>
                    </div>

                    <br />


                    <div class="row">

                        <div class="col-lg-3">
                            <select class="selectpicker" data-width="100%" name="reply_accounts[]" title="Reply from" multiple>
                                <optgroup label="Accounts">
                                    <?php
                                    foreach ($oAuth as $key => $value ) {
                                        ?>
                                        <option value="<?php echo $value['hashtag_oauth_account_name']; ?>">@<?php echo $value['hashtag_oauth_account_name']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </optgroup>
                                <optgroup label="Randomise">
                                    <option value="random">Random from selected</option>
                                </optgroup>
                            </select>

                        </div>


                        <div class="col-lg-3">

                        </div>


                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-addon">Throttling: </span>
                                <input type="text" class="form-control num-input" placeholder="Max replies" name="reply_throttle">
                                <span class="input-group-addon">every hour</span>
                                <?php /*
                                <div class="input-group-btn btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Frequency <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu" name="reply_frequency">
                                        <li><a href="#">every minute</a></li>
                                        <li><a href="#">every 5 minutes</a></li>
                                        <li><a href="#">every 15 minutes</a></li>
                                        <li><a href="#">every 30 minutes</a></li>
                                        <li><a href="#">every 45 minutes</a></li>
                                        <li><a href="#">every hour</a></li>
                                    </ul>
                                </div>
                                */ ?>
                            </div>
                        </div>


                        <div class="col-lg-2">
                            <button type="submit" id="reply_save" data-loading-text="Saving..." class="btn btn-primary" autocomplete="off">Save</button>

                            <button type="reset" id="reply_cancel" class="btn btn-secondary" autocomplete="off">Cancel</button>
                        </div>

                    </div>

                    <br />
                    <input type="hidden" name="reply_form_submit" value="true" />
                </form>
                <?php if ( isset( $replies ) && $replies != '' && is_array( $replies ) && count( $replies ) > 0 ) { ?>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading"><span class="replies"><span class="glyphicon glyphicon-share-alt"></span>  Replies</span></div>

                                <table class="table" data-toggle="table" data-height="299">

                                    <tr>
                                        <th># ID</th>
                                        <th>Hashtags</th>
                                        <th>Accounts</th>
                                        <th>Random</th>
                                        <th>Message</th>
                                        <th>Throttling (p/min)</th>
                                        <th>Manage</th>
                                    </tr>

                                    <?php foreach ( $replies as $key => $reply ) { ?>

                                        <tr>
                                            <td>
                                                <?php echo $reply['hashtag_admin_reply_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $reply['hashtag_admin_reply_hashtags']; ?>
                                            </td>
                                            <td>
                                                <?php echo $reply['hashtag_admin_reply_accounts']; ?>
                                            </td>
                                            <td>
                                                <?php if ( $reply['hashtag_admin_reply_random'] == 1 ) { echo 'Yes'; } else { echo 'No'; } ?>
                                            </td>
                                            <td>
                                                <?php echo $reply['hashtag_admin_reply_message']; ?>
                                            </td>
                                            <td>
                                                <?php echo $reply['hashtag_admin_reply_throttling']; ?>
                                            </td>
                                            <td>
                                                <form name="pause_reply" action="" method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="pause_reply_id" value="<?php echo $reply['hashtag_admin_reply_id']; ?>" />
                                                    <?php if ( $reply['hashtag_admin_reply_frequency'] == 1 ) { ?>
                                                        <input type="hidden" name="pause_reply_frequency" value="0" />
                                                        <button class="btn btn-warning btn-xs" type="submit">Pause</button>
                                                        <?php } else { ?>
                                                            <input type="hidden" name="pause_reply_frequency" value="1" />
                                                            <button class="btn btn-success btn-xs" type="submit">Start</button>
                                                            <?php } ?>
                                                        </form>
                                                <form name="delete_reply" action="" method="POST" style="display: inline-block;">
                                                    <input type="hidden" name="delete_reply_id" value="<?php echo $reply['hashtag_admin_reply_id']; ?>" />
                                                    <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </table>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
<!-- // ####### REPLIES PANEL ####### -->






            <div role="tabpanel" class="tab-pane" id="settings">
                <div class="row">
                    <div class="col-lg-12">
                        <p style="padding-left: 10px;">
                            <br />
                            No settings to display. Possible future extension?
                        </p>
                    </div>
                </div>
            </div>







            <div role="tabpanel" class="tab-pane" id="accounts">
                <br />
                <div class="row">

                    <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading"><span class="accounts"><span class="glyphicon glyphicon-user"></span> Accounts</span></div>



                            <table class="table" data-toggle="table" data-height="299" style="width: 100%;">

                                <tr>
                                    <th>ID #</th>
                                    <th>Account Name</th>
                                    <th>Manage</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>

                                <?php foreach ( $oAuth as $key => $value ) { ?>

                                    <tr>
                                        <td>
                                            <?php echo $value['hashtag_oauth_settings_id']; ?>
                                        </td>
                                        <td>
                                            <a href="https://twitter.com/<?php echo $value['hashtag_oauth_account_name']; ?>" target="_BLANK">@<?php echo $value['hashtag_oauth_account_name']; ?></a>
                                        <td>
                                            <form name="delete_account" action="" method="POST">
                                                <input type="hidden" name="delete_account_id" value="<?php echo $value['hashtag_oauth_settings_id']; ?>" />
                                                <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <?php } ?>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
<!-- ####### // TABBED PANELS ####### -->

    </div>
<!-- ####### // MAIN PANEL ####### -->



<!-- ####### OATH SETTINGS MODAL CONTENT ####### -->
<form name="oauth_settings_form" id="oauth_settings_form" method="POST" action="">
    <div class="modal fade" id="oAuthSettingsModal" tabindex="-1" role="dialog" aria-labelledby="oAuthSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="oAuthSettingsModalLabel">Add Account</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Consumer key: </span>
                                <input type="text" class="form-control" name="hashtag_oauth_consumer_key" id="hashtag_oauth_consumer_key" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>

                        <div class="col-lg-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Consumer secret: </span>
                                <input type="text" class="form-control" name="hashtag_oauth_consumer_secret" id="hashtag_oauth_consumer_secret" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>

                        <div class="col-lg-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Access token: </span>
                                <input type="text" class="form-control" name="hashtag_oauth_access_token" id="hashtag_oauth_access_token" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>

                        <div class="col-lg-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Access token secret: </span>
                                <input type="text" class="form-control" name="hashtag_oauth_access_token_secret" id="hashtag_oauth_access_token_secret" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>


                        <div class="col-lg-10">
                            <input type="hidden" name="oauth_settings_form_submit" value="true" />
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" id="oauth_save_button" data-loading-text="Saving..." class="btn btn-primary" autocomplete="off">Save</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
<!-- ####### // OATH SETTINGS MODAL CONTENT ####### -->


<!-- ####### OATH INSTRUCTIONS MODAL CONTENT ####### -->
    <div class="modal fade" id="oAuthInstructionsModal" tabindex="-1" role="dialog" aria-labelledby="oAuthInstructionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="oAuthInstructionsModalLabel">oAuth Setup Instructions</h4>
                </div>
                <div class="modal-body">

                    <p>
                        <strong>Step 1. </strong> Go to <a href="https://dev.twitter.com/apps" target="_BLANK">https://dev.twitter.com/apps</a> and sign in with your account.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_001.png', __FILE__); ?>" style="width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 2. </strong> Press 'Create a new application' button.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_002.png', __FILE__); ?>" style="width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 3. </strong> Complete the required fields and press 'Create your Twitter application' (in the bottom of the screen).<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_003.png', __FILE__); ?>" style="width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 4. </strong> Go to 'Settings' TAB and set 'Application Type' to 'Read and Write'. Then press 'Update this Twitter application's settings'.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_004.png', __FILE__); ?>" style="width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 5. </strong> Go to 'Details' TAB and press 'Create my access token' button.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_005.png', __FILE__); ?>" style="width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 6. </strong> Go to 'oAuth tool TAB' and get your access tokens.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_006.png', __FILE__); ?>" style="width: 100%;" /><br />
                    </p>

                    <?php
                    /*
                    Instructions and images courtesy of http://www.pontikis.net/blog/auto_post_on_twitter_with_php
                    */
                    ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- ####### // OATH INSTRUCTIONS MODAL CONTENT ####### -->

</div>

<!-- ####### // FIN ####### -->
