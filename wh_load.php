<?php
require_once("database.php");
require_once("models/functions.php");
date_default_timezone_set('Europe/Samara');

$link = db_connect();


	for($j=1; $j<6; $j++){ // Floors
		for($i=21; $i<22; $i++){  // Pallets
			$r = 2;
			$rack = str_pad($r, 2, '0', STR_PAD_LEFT); 
			$pallet = str_pad($i, 2, '0', STR_PAD_LEFT); 
			$floor = str_pad($j, 2, '0', STR_PAD_LEFT);  
			$address = $rack.".".$pallet.".".$floor;
			$loc = 'W';
			echo $address."  ".$i."   ".$j;
			echo '<br>';
			$q = 'INSERT INTO `joga_db`.`warehouse` (`address`, `location`, `rack`, `pallet`, `floor`) VALUES ("%s", "%s", "%s", "%s", "%s")';
			$query = sprintf($q, $address, $loc, $r, $i, $j);
			$result = mysqli_query($link, $query);
			
			if(!$result)
				die(mysqli_error($link));
			
			
			// PRINTING
			//$filepath = lbl_update_wh ($address, $rack, $pallet, $floor);
			//lbl_print($filepath);
		
		
		
			
		}
	}
//$n = mysqli_num_rows($result);
//return $n;
//echo $n.' locations inserted';
?>