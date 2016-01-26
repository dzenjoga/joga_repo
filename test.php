<?php
require_once("database.php");
require_once("models/functions.php");
date_default_timezone_set('Europe/Samara');

$link = db_connect();


//$command = 'Rec_label_print.bat';



$address = "01.01.02"; 
$rack = "01"; 
$pallet = "01";
$floor = "02";

$path = lbl_update_wh ($address, $rack, $pallet, $floor);
echo $path;
lbl_print($path);


?>