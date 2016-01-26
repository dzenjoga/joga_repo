<?php
require_once("database.php");
require_once("models/functions.php");
date_default_timezone_set('Europe/Samara');

$link = db_connect();

$file = 'parts.csv';

function parts_load ($link, $file) {

	$row = 1;
	$handle = fopen($file, "r");

	while( !feof($handle) ){
		$data = fgetcsv($handle, 300, ";");
		$num = count($data); // Number of columns
		
		//echo "<p> $num полей в строке $row: <br /></p>\n";
		//echo "String ".$row." Number of columns " .$num."<br><br>";
		
		$row++;
		
		if($row > 2) {
			$part_number = $data[0];	
			$supplier = $data[1];
					
			echo $part_number . '  - ' .  $supplier  . ' <br>';// . $part_number . '  - ' . $quantity . "<br><br>";
			$q = 'INSERT INTO `joga_db`.`parts` (`part_number`, `supplier`) VALUES ("%s", "%s")';
			$query = sprintf($q, $part_number, $supplier);
			$result = mysqli_query($link, $query);
		
			if(!$result)
				die(mysqli_error($link));
		
		}
	}
	fclose($handle);
	$labels_added = $row - 2;
	return $labels_added;
}
parts_load ($link, $file);
/*
	for($j=1; $j<6; $j++){
		for($i=1; $i<25; $i++){
			$r = 6;
			$rack = str_pad($r, 2, '0', STR_PAD_LEFT); 
			$pallet = str_pad($i, 2, '0', STR_PAD_LEFT); 
			$floor = str_pad($j, 2, '0', STR_PAD_LEFT);  
			$address = $rack.".".$pallet.".".$floor;
			$loc = 'W';
			echo $address."   ".$i."   ".$j;
			echo '<br>';
			$q = 'INSERT INTO `joga_db`.`warehouse` (`address`, `location`, `rack`, `pallet`, `floor`) VALUES ("%s", "%s", "%s", "%s", "%s")';
			$query = sprintf($q, $address, $loc, $r, $i, $j);
			$result = mysqli_query($link, $query);
		
			if(!$result)
				die(mysqli_error($link));
		
			//$n = mysqli_num_rows($result);
			//return $n;
			//echo $n;
		}
	}
*/
?>