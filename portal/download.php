<?php
include('session.php');



$file="../upload/".$_GET['records'].".txt";
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"'); 
header('Content-Length: ' . filesize($file));
readfile($file);

?>