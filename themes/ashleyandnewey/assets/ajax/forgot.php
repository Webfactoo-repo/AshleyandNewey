<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

if($_POST && !current_user_can('administrator')){
    $email = $wpdb->escape($_REQUEST['email']);
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
        echo "Please enter a valid email address.";
        exit();
    }

    $query = $wpdb->query("SELECT * FROM andev_users WHERE user_email='$email'");
    if (!$query){
        echo 'Sorry, this is not an existing email address.';
        exit();
    } else {
        $key = wp_generate_password( 25, false );

        $wpdb->update(
            'andev_users',
            array(
                'user_activation_key' => $key,
            ),
            array( 'user_email' => $email ),
            array(
                '%s',
            ),
            array( '%s' )
        );

        $from = get_option('admin_email');
        $headers = 'From: '.$from . "\r\n";
        $subject = "Ashley & Newey - Reminder";
        $url = home_url();
        $msg = "Activation link:\n$url/change-my-password?key=$key";
        wp_mail( $email, $subject, $msg, $headers );

        echo 'Please set your new password!';
    }
}
?>