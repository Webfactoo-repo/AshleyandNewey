<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb, $user_ID;

$test = $_GET['url'];
$file="booking_status.xls";

$user_info = get_userdata($user_ID);
$to = $user_info->user_email;
$subject = 'Ashley & Newey - Document';
$from = get_option('admin_email');

$header = 'From: ' . $from . "\r\n";
$content = chunk_split(base64_encode($test));
$uniqident = md5(uniqid(time()));
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uniqident."\"\r\n\r\n";
$header .= "This is a multi-part message in MIME format.\r\n";
$header .= "--".$uniqident."\r\n";
$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$header .= $message."\r\n\r\n";
$header .= "--".$uniqident."\r\n";
$header .= "Content-Type: application/octet-stream; name=\"".$file."\"\r\n"; // use different content types here
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$file."\"\r\n\r\n";
$header .= $content."\r\n\r\n";
$header .= "--".$uniqident."--";
mail ($to, $subject, $message, $header);
?>