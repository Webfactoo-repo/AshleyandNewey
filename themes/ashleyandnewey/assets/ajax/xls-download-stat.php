<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb, $user_ID;
$filename = "booking_status.xls";
$wpdb->insert(
    'andev_user_activity',
    array(
        'user_id' => $user_ID,
        'act' => 'DOWNLOAD',
        'file' => basename($filename)
    ),
    array(
        '%d',
        '%s',
        '%s'
    )
);
?>