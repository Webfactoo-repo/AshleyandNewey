<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

if($_POST){
    $username = $wpdb->escape($_REQUEST['username']);
    $password = $wpdb->escape($_REQUEST['password']);

    $login_data = array();
    $login_data['user_login'] = $username;
    $login_data['user_password'] = $password;
    $user_verify = wp_signon( $login_data, true );

    if ( is_wp_error($user_verify) ) {
        echo "Wrong username or password.";
        exit();
    } else {
        echo "ok";
    }
}
?>