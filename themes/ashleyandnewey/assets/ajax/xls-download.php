<?php
    $test = $_GET['url'];
    $file="booking_status.xls";
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file");
    echo $test;
?>