<?php

/*

global $wpdb;

include_once( plugins_url( 'functions/twitter-api.php', __FILE__ ) );

$oauth_settings_table = $wpdb->prefix . 'bbp_tweet_oauth_settings';
$forum_settings_table = $wpdb->prefix . 'bbp_tweet_forum_settings';

$oauth_settings = $wpdb->get_results( "SELECT * FROM $oauth_settings_table", ARRAY_A );
$bbp_tweet_topics = $wpdb->get_results( "SELECT `bbp_tweet_forum_settings_topics` FROM $forum_settings_table", ARRAY_A );
$bbp_tweet_replies = $wpdb->get_results( "SELECT `bbp_tweet_forum_settings_replies` FROM $forum_settings_table", ARRAY_A );

*/

?>

<!-- ####### START ####### -->
<div id="bbp-tweet" class="container-fluid">

    <h3 class="bbp-tweet-header">bbp tweet</h3>

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
                        foreach ($oAuth as $key => $value ) {
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


                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading"><span class="stats"><span class="glyphicon glyphicon-stats"></span> Stats</span></div>

                        <p style="padding: 10px;">Possible future extension?</p>
                    </div>

                </div>

            </div>
<!-- ####### // DASHBOARD PANEL ####### -->




            <div role="tabpanel" class="tab-pane" id="settings">
                <div class="row">
                    <div class="col-md-12">
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

                    <div class="col-md-12">

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

                                <?php /* foreach ( $oAuth as $key => $value ) { ?>

                                    <tr>
                                        <td>
                                            <?php echo $value['bbp_tweet_oauth_settings_id']; ?>
                                        </td>
                                        <td>
                                            <a href="https://twitter.com/<?php echo $value['bbp_tweet_oauth_account_name']; ?>" target="_BLANK">@<?php echo $value['bbp_tweet_oauth_account_name']; ?></a>
                                        <td>
                                            <form name="delete_account" action="" method="POST">
                                                <input type="hidden" name="delete_account_id" value="<?php echo $value['bbp_tweet_oauth_settings_id']; ?>" />
                                                <button class="btn btn-danger btn-xs" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <?php } */ ?>

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

<!-- ####### // FIN ####### -->
