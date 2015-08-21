<?php

    global $wpdb;

    $oauth_settings_table = $wpdb->prefix . 'bbp_tweet_oauth_settings';
    $forum_settings_table = $wpdb->prefix . 'bbp_tweet_forum_settings';


    // Saving new topics and replies settings
    if ( $_POST['bbp-tweet-save-settings'] == 1 ) {

        $wpdb->query( "TRUNCATE TABLE $forum_settings_table" );

        $bbp_tweet_settings_insert = $wpdb->insert( $forum_settings_table, array( 'bbp_tweet_forum_settings_topics' => $_POST['bbp-tweet-topics'], 'bbp_tweet_forum_settings_replies' => $_POST['bbp-tweet-replies'] ), array( '%d' ) );

        if ( $bbp_tweet_settings_insert != false ) {
            $success = true;
            $message = 'Your settings were updated.';
        } else {
            $success = false;
            $message = 'There was a problem updating your settings. Please try again.';
        }


    }

    $oauth_settings_results = $wpdb->get_results( "SELECT * FROM $oauth_settings_table", ARRAY_A );
    $bbp_tweet_topics_results = $wpdb->get_results( "SELECT bbp_tweet_forum_settings_topics FROM $forum_settings_table WHERE bbp_tweet_forum_settings_id = 1", ARRAY_A );
    $bbp_tweet_replies_results = $wpdb->get_results( "SELECT bbp_tweet_forum_settings_replies FROM $forum_settings_table WHERE bbp_tweet_forum_settings_id = 1", ARRAY_A );

    // var_dump( $oauth_settings_results );
    $bbp_tweet_topics = $bbp_tweet_topics_results[0]['bbp_tweet_forum_settings_topics'];
    $bbp_tweet_replies = $bbp_tweet_replies_results[0]['bbp_tweet_forum_settings_replies'];

?>

<!-- ####### START ####### -->
<div id="bbp-tweet" class="container-fluid">

    <h3 class="bbp-tweet-header">bbp tweet</h3>

    <?php if ( isset( $success ) && $success == true ) { ?>
        <div class="success alert alert-success" role="alert">
            <a href="#" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove"></span></a>
            <p><span class="glyphicon glyphicon-ok-sign"></span> <b>Success: </b>
                <span class="message"><?php echo $message; ?></span>
            </p>
        </div>
    <?php } ?>

    <?php if ( isset( $success ) && $success == false ) { ?>
        <div class="error alert alert-danger" role="alert">
            <a href="#" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove"></span></a>
            <p><span class="glyphicon glyphicon-exclamation-sign"></span> <b>Error: </b>
                <span class="message"><?php echo $message; ?></span>
            </p>
        </div>
    <?php } ?>


    <?php if ( $oauth_settings[0]['bbp_tweet_oauth_account_name'] == '' || $oauth_settings[0]['bbp_tweet_oauth_consumer_key'] == '' || $oauth_settings[0]['bbp_tweet_oauth_consumer_secret'] == '' || $oauth_settings[0]['bbp_tweet_oauth_access_token'] == '' || $oauth_settings[0]['bbp_tweet_oauth_access_token_secret'] == '') { ?>
<!-- ####### // OATH WARNING ####### -->
        <div class="alert alert-danger fade in" role="alert">
            <h4><span class="glyphicon glyphicon-exclamation-sign"></span> Authentication Error</h4>
            <p>In order for this plugin to function correctly you must setup a Twitter application and enter your OAuth credentials.</p>
            <p>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#oAuthInstructionsModal">Instructions</button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#oAuthSettingsModal">Do this now</button>
            </p>
        </div>
<!-- ####### // OATH WARNING ####### -->
    <?php } ?>


<!-- #######  MAIN PANEL ####### -->
    <div role="tabpanel">

<!-- ####### TOP NAVIGATION ####### -->
        <ul class="nav nav-tabs" role="tablist">

            <li role="presentation" class="active"><a href="#dashboard" aria-controls="dashboard" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span> Dashboard</a></li>

            <li role="settings"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>

            <li class="dropdown">
                <a href="#" aria-controls="accounts" role="tab"  data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-user"></span> Accounts</a>
                <ul class="dropdown-menu">
                    <?php
                        foreach ($oauth_settings as $key => $value ) {
                    ?>
                        <li class="disabled"><a href="#">@<?php echo $value['bbp_tweet_oauth_account_name']; ?></a></li>
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
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><span class="stats"><span class="glyphicon glyphicon-tasks"></span> Activity</span></div>

                            <p style="padding: 10px;">Possible future extension?</p>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><span class="stats"><span class="glyphicon glyphicon-stats"></span> Stats</span></div>

                            <p style="padding: 10px;">Possible future extension?</p>
                        </div>
                    </div>
                </div>

            </div>
<!-- ####### // DASHBOARD PANEL ####### -->




            <div role="tabpanel" class="tab-pane" id="settings">
<br />
                <form name="bbp-tweet-settings" action="" method="post" id="bbp-tweet-settings">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><span class="stats"><span class="glyphicon glyphicon-edit"></span> Topics</span></div>

                                <div class="form-group">

                                    <div class="checkbox">
                                        <label for="bbp-tweet-topics">
                                            <span class="col-md-1"><input type="checkbox" name="bbp-tweet-topics" id="bbp-tweet-topics" value="1" <?php if ( $bbp_tweet_topics == 1 ) { echo 'checked="checked"'; } ?> /></span>
                                            <span class="col-md-11">Tweet New Topics?</span>
                                        </label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><span class="stats"><span class="glyphicon glyphicon-comment"></span> Replies</span></div>

                                <div class="form-group">

                                    <div class="checkbox">
                                        <label for="bbp-tweet-replies">
                                            <span class="col-md-1"><input type="checkbox" name="bbp-tweet-replies" id="bbp-tweet-replies" value="1" <?php if ( $bbp_tweet_replies == 1 ) { echo 'checked="checked"'; } ?> /></span>
                                            <span class="col-md-11">Tweet New Replies?</span>
                                        </label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" name="settings-save-button" id="settings-save-button" class="btn btn-success col-md-1 col-md-offset-11">Save</button>
                        </div>
                    </div>

                    <input type="hidden" name="bbp-tweet-save-settings" value="1" />

                </form>
            </div>


            <div role="tabpanel" class="tab-pane" id="accounts">
                <br />
                <div class="row">

                    <div class="col-md-12">

                        <div class="panel panel-default">
                            <div class="panel-heading"><span class="accounts"><span class="glyphicon glyphicon-user"></span> Accounts</span></div>



                            <table class="table table-striped table-bordered table-hover table-condensed" data-toggle="table" data-height="299">

                                <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Account Name</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ( $oauth_settings as $key => $value ) { ?>

                                        <tr>
                                            <td>
                                                <?php echo $value['bbp_tweet_oauth_settings_id']; ?>
                                            </td>
                                            <td>
                                                <a href="https://twitter.com/<?php echo $value['bbp_tweet_oauth_account_name']; ?>" target="_BLANK">@<?php echo $value['bbp_tweet_oauth_account_name']; ?></a>
                                            <td>
                                                <form name="oauth_delete_account" id="oauth_delete_account">
                                                    <input type="hidden" name="delete_account_id" value="<?php echo $value['bbp_tweet_oauth_settings_id']; ?>" />
                                                    <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <?php } ?>

                                    </tbody>

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
<form name="oauth_settings_form" id="oauth_settings_form">
    <div class="modal fade" id="oAuthSettingsModal" tabindex="-1" role="dialog" aria-labelledby="oAuthSettingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="oAuthSettingsModalLabel">Add Account</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Consumer key: </span>
                                <input type="text" class="form-control" name="bbp_tweet_oauth_consumer_key" id="bbp_tweet_oauth_consumer_key" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>

                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Consumer secret: </span>
                                <input type="text" class="form-control" name="bbp_tweet_oauth_consumer_secret" id="bbp_tweet_oauth_consumer_secret" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>

                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Access token: </span>
                                <input type="text" class="form-control" name="bbp_tweet_oauth_access_token" id="bbp_tweet_oauth_access_token" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>

                        <div class="col-md-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="min-width: 150px;">Access token secret: </span>
                                <input type="text" class="form-control" name="bbp_tweet_oauth_access_token_secret" id="bbp_tweet_oauth_access_token_secret" placeholder="" style="width: 400px;">
                            </div>
                            <br />
                        </div>


                        <div class="col-md-10">
                            <input type="hidden" name="oauth_settings_form_submit" value="true" />
                        </div>
                        <div class="col-md-2">
                            <button type="submit" id="oauth-save-button"  class="btn btn-primary">Save</button>
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
                        <img src="<?php echo plugins_url('img/twitter_app_001.png', __FILE__); ?>" style="max-width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 2. </strong> Press 'Create a new application' button.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_002.png', __FILE__); ?>" style="max-width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 3. </strong> Complete the required fields and press 'Create your Twitter application' (in the bottom of the screen).<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_003.png', __FILE__); ?>" style="max-width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 4. </strong> Go to 'Settings' TAB and set 'Application Type' to 'Read and Write'. Then press 'Update this Twitter application's settings'.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_004.png', __FILE__); ?>" style="max-width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 5. </strong> Go to 'Details' TAB and press 'Create my access token' button.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_005.png', __FILE__); ?>" style="max-width: 100%;" /><br />
                    </p>

                    <p><br /></p>

                    <p>
                        <strong>Step 6. </strong> Go to 'oAuth tool TAB' and get your access tokens.<br /><br />
                        <img src="<?php echo plugins_url('img/twitter_app_006.png', __FILE__); ?>" style="max-width: 100%;" /><br />
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

<div style="clear: both;"></div>

<!-- ####### // FIN ####### -->
