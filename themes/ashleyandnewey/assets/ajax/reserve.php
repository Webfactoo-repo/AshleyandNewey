<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
global $wpdb, $user_ID;

if($_POST && !current_user_can('administrator')){
    $id = $wpdb->escape($_REQUEST['id']);
    $date = $wpdb->escape($_REQUEST['date']);
    $dateid = $wpdb->escape($_REQUEST['dateid']);

    $num = $wpdb->get_var( "SELECT COUNT(*) FROM andev_reservations WHERE user_id = '$user_ID' AND tour_id = '$id' AND date_id = '$dateid'" );

    $ptitle=get_the_title($id);
    $res=$ptitle." - ".$date;

    if ($num == 0){
        $num2 = $wpdb->get_var( "SELECT COUNT(*) FROM andev_reservations WHERE tour_id = '$id' AND date_id = '$dateid'" );
        if ($num2 == 0){
            $wpdb->insert(
                'andev_reservations',
                array(
                    'user_id' => $user_ID,
                    'tour_id' => $id,
                    'date' => $date,
                    'date_id' => $dateid,
                    'status' => 1
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%s',
                    '%d'
                )
            );

            $wpdb->insert(
                'andev_user_activity',
                array(
                    'user_id' => $user_ID,
                    'act' => 'RESERVATION',
                    'file' => $res
                ),
                array(
                    '%d',
                    '%s',
                    '%s'
                )
            );

            $user_info = get_userdata($user_ID);
            echo "(opt) ".$user_info->user_lastname;
        } else {
            echo "reserved";
        }
    } else {
        $num3 = $wpdb->get_var( "SELECT COUNT(*) FROM andev_reservations WHERE user_id = '$user_ID' AND tour_id = '$id' AND date_id = '$dateid' AND status=2" );
        if ($num3 == 0){
            $wpdb->query("DELETE FROM andev_reservations WHERE user_id = '$user_ID' AND tour_id = '$id' AND date_id = '$dateid'");

            $wpdb->insert(
                'andev_user_activity',
                array(
                    'user_id' => $user_ID,
                    'act' => 'DEL RESERVATION',
                    'file' => $res
                ),
                array(
                    '%d',
                    '%s',
                    '%s'
                )
            );

            echo 'free';
        } else {
            echo 'reserved';
        }
    }

}

?>