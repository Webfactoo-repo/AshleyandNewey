<?php
error_reporting(E_ALL);
ini_set("display_errors","1");
ini_set("html_errors","1");

function weekday($date){
    $eTime = time();
//        echo date("F j, Y, g:i a", time());
    $wday= 0;
    while($wday != 2){
        $eTime = strtotime("-1 day",$eTime);
        if(date('w', $eTime) != 6 && date('w', $eTime) != 0) {
            $wday++;
        }
    }

    if (strtotime($date) < $eTime){
        return 1;
    } else {
        return 0;
    }
}
//    echo weekday("2013-06-14 10:02");


$host="localhost";
$user="ashley_anewey";
$pass="m#X5ReJ@wAl9";
$db="ashley_neweywebsite";

$con = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno($con))
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$query = mysqli_query($con, "SELECT id, time, status FROM andev_reservations");
while($row = mysqli_fetch_array($query)){
    if (weekday($row['time']) == 1 && $row['status'] != 2){
        $id = $row['id'];
        mysqli_query($con, "DELETE FROM andev_reservations WHERE id='$id'");
        //$delete = "DELETE FROM andev_reservations WHERE id='$id'";
        //mysqli_query($delete);
    }
}

mysqli_close($con);
?>