<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb, $user_ID;

if($_POST && !current_user_can('administrator')){
   $user_info = get_userdata($user_ID);
   $url = $wpdb->escape($_REQUEST['url']);

   $attachments = array(ABSPATH . '/assets/' . basename($url));;
   $email = $user_info->user_email;
   $from = get_option('admin_email');
   $headers = 'From: '.$from . "\r\n";
   $subject = "Ashley & Newey - Document";
   $msg="Document";
   wp_mail( $email, $subject, $msg, $headers, $attachments );
}
?>