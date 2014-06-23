<?php

$filename = "http://www.ashleynewey.co.uk/assets/".$_GET['url'];

header('Content-disposition: attachment; filename='.basename($filename));
//    header("Content-type: ".mime_content_type(basename($filename)));
header('Content-Type: application/octet-stream');

ob_clean();
flush();

readfile($filename);



?>