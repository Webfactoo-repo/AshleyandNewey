<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb;

if($_POST && current_user_can('administrator')) {

    $tourid = $wpdb->escape($_REQUEST['tourid']);
    $resid = $wpdb->escape($_REQUEST['resid']);
    $userid = $wpdb->escape($_REQUEST['userid']);
    $date = $wpdb->escape($_REQUEST['date']);
    $dateid = $wpdb->escape($_REQUEST['dateid']);

    $ptitle=get_the_title($tourid);
    $res=$ptitle." - ".$date;

	$num = $wpdb->get_var( "SELECT COUNT(*) FROM andev_reservations WHERE tour_id = '$tourid' AND date_id = '$dateid'" );

    if ($resid == 0 && $num == 0){
        $wpdb->insert(
            'andev_reservations',
            array(
                'user_id' => $userid,
                'tour_id' => $tourid,
                'date' => $date,
                'date_id' => $dateid,
                'status' => 2
            ),
            array(
                '%d',
                '%d',
                '%s',
                '%s',
                '%d'
            )
        );


        echo $wpdb->insert_id;
    } else {
        $wpdb->update(
            'andev_reservations',
            array(
                'user_id' => $userid,
                'status' => 2
            ),
            array(
                'id' => $resid,
            ),
            array(
                '%d',
                '%d'
            ),
            array(
                '%d'
            )
        );
        echo $resid;
    }
} 


?>