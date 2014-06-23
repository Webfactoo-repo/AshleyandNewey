<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

if($_POST && !current_user_can('administrator')){

    $pass1 = $wpdb->escape($_REQUEST['newpassword']);
    if(empty($pass1)) {
        echo "New Password should not be empty.";
        exit();
    }

    if(!preg_match('/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/', $pass1)) {
        echo 'Password should be at least 8 characters and should contain at least one lower case letter, one upper case letter and one digit.';
        exit();
    }

    $pass2 = $wpdb->escape($_REQUEST['newpassworda']);
    if(empty($pass2)) {
        echo "New Password Again should not be empty.";
        exit();
    }

    if($pass1 != $pass2){
        echo "Password does not match the confirm password.";
        exit();
    }

    $id = $wpdb->escape($_REQUEST['userid']);

    wp_set_password($pass2, $id);

    $wpdb->update(
        'andev_users',
        array(
            'ID' => $id,
        ),
        array( 'user_activation' => '' ),
        array(
            '%s',
        ),
        array( '%s' )
    );

    $wpdb->insert(
        'andev_user_activity',
        array(
            'user_id' => $id,
            'act' => 'CHANGE PASSWORD',
            'file' => ''
        ),
        array(
            '%d',
            '%s',
            '%s'
        )
    );

    echo 'The password has been successfully changed.';
}
?>