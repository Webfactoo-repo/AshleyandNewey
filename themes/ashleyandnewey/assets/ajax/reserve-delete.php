<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

if($_POST && current_user_can('administrator')){
    $id = $wpdb->escape($_REQUEST['id']);

    $wpdb->query("DELETE FROM andev_reservations WHERE id = '$id'");
}

?>