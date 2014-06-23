<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

if($_POST && current_user_can('administrator')){
    $id = $wpdb->escape($_REQUEST['id']);

    $wpdb->update(
        'andev_reservations',
        array(
            'status' => 2,
        ),
        array( 'id' => $id ),
        array(
            '%d'
        ),
        array( '%d' )
    );
}

?>