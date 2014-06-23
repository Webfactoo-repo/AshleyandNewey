<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

if($_POST){
    $name = $wpdb->escape($_REQUEST['name']);
    if(empty($name)) {
        echo "Name should not be empty.";
        exit();
    }

    $email = $wpdb->escape($_REQUEST['email']);
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
        echo "Please enter a valid email address.";
        exit();
    }

    $phone = $wpdb->escape($_REQUEST['phone']);
    if(empty($phone)) {
        echo "Phone should not be empty.";
        exit();
    }

    $to = get_option('admin_email');
    $headers = 'From: '.$email . "\r\n";
    $subject = "Ashley & Newey Request";
    $msg = "Not a partner yet' contact request from ashleynewey.co.uk.\nContact details:\nName: $name\nEmail: $email\nPhone: $phone";
    wp_mail( $to, $subject, $msg, $headers );
    echo "Thank you for your request we will contact you soon.";
    exit();
}
?>