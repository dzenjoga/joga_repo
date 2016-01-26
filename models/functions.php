<?php

/* Download all labels table in CSV format (except signed off)
fclose($fp);

    $len = str_pad($len, 8, '0', STR_PAD_LEFT);

    $filepath ='rec_label.txt';
    $fp = fopen($filepath,'w');
        $filecon = str_replace('$Part_number$',$part_number,$filecon);
        $filecon = str_replace('$Quantity$',$quantity,$filecon);
        $filecon = str_replace('$Date$',$date,$filecon);
        $filecon = str_replace('$Label_ID$',$len,$filecon);
    fwrite($fp, $filecon);
	
*/

function date_form ($date){
$date = $date[6].$date[7].$date[8].$date[9].".".$date[3].$date[4].".".$date[0].$date[1];
return $date;
}
//______________ REPORT FUNCTIONs ______________
function view_wh_csv ($link) { 
		$labels = get_lbl_arr($link);

	$timest = date("d.m.Y H.i.s");
	//$path = 'F:\Public\4. Logistics\WMS reports';
	$filepath = 'F:\Public\4. Logistics\WMS reports'.'\warehouse\warehouse loading on '.$timest.'.csv';
	$fp = fopen($filepath,'a');
		$wh_str = 'Address;Label_ID;Part_number;Quantity;Receiving date'."\r\n"; 
		$test = fwrite($fp, $wh_str); 
		//if($test) echo 'Данные в файл успешно занесены.';
		//else echo 'Ошибка при записи в файл.';
		
		foreach($labels as $a):
					if($a['address'] != 'SIGNED OFF'){
						$wh_str = $a['address'].';'.$a['label_id'].';'.$a['part_number'].';'.$a['quantity'].';'.$a['date']."\r\n"; 
						$test = fwrite($fp, $wh_str); 
						//if($test) echo 'Данные в файл успешно занесены.';
						//else echo 'Ошибка при записи в файл.';
					}
		endforeach;
}

//______________ CHECK FUNCTIONs ______________
function check_addr ($link, $to_addr){ /* Check if the adderess exist in warehouse table */
    
    $q = 'SELECT address FROM warehouse WHERE address = "%s"';
    $query = sprintf($q, $to_addr);
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $n = mysqli_num_rows($result);
    return $n;
}

function check_part ($link, $part_number){ /* Check if the adderess exist in warehouse table */
    
    $q = 'SELECT part_number FROM parts WHERE part_number = "%s"';
    $query = sprintf($q, $part_number);
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $n = mysqli_num_rows($result);
    return $n;
}

function check_part_csv ($link, $file) {
	$err = 0; // Number of part_numbers which don't exist in the DB
	$row = 1;
	$handle = fopen($file, "r");
	
	while( !feof($handle) ){
		$data = fgetcsv	($handle, 300, ";");
		//$num = count($data); // Number of columns
		$row++; // Number of part_numbers which don't exist in the DB
		
		
		if($row > 2) {
			$part_number = $data[2];
			$status = check_part ($link, $part_number);			
			if ($status == 0)
				$err++; // Number of part_numbers which don't exist in the DB
		}
	}
		return $err;
}

//______________ SEARCH FUNCTIONs ______________

function search_pn ($link, $part_number){ /* Search all the labels with part number in labels table */

    $q = 'SELECT * FROM labels WHERE part_number = "%s"  ORDER BY date';
    $query = sprintf($q, mysqli_real_escape_string($link, $part_number));
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $n = mysqli_num_rows($result);
    $arr = array();
    
    for($i = 0; $i < $n; $i++){
    $row = mysqli_fetch_assoc($result);
    $arr[] = $row;
    }
        
    return $arr;
}

function search_addr ($link, $address){ /* Search all the labels on exact address in labels table */

    $q = 'SELECT * FROM labels WHERE address = "%s"  ORDER BY part_number, date';
    $query = sprintf($q, mysqli_real_escape_string($link, $address));
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $n = mysqli_num_rows($result);
    $arr = array();
    
    for($i = 0; $i < $n; $i++){
    $row = mysqli_fetch_assoc($result);
    $arr[] = $row;
    }
        
    return $arr;
}

//______________ NEW LABEL FUNCTIONs ______________
// ADD to DATABASE
function lbl_add ($link, $action, $part_number, $quantity, $date, $receiver, $fr_addr, $to_addr){  // ADD LABEL
    $user = 'username';
    $comment = "Receiver: ".$receiver; 
    $part_number = trim($part_number);
	$n = check_part ($link, $part_number);
		if ($n > 0){  // If part_number exist in parts table
			$t = "INSERT INTO labels (part_number, quantity, date, receiver, address) VALUES('%s','%s','%s', '%s', '%s')";
			$query = sprintf($t, mysqli_real_escape_string($link,$part_number), mysqli_real_escape_string($link,$quantity), mysqli_real_escape_string($link,$date), mysqli_real_escape_string($link,$receiver), mysqli_real_escape_string($link,$to_addr));
			$result = mysqli_query($link,$query);
			if(!$result)
				die(mysqli_error($link));
			else {
				//$temp = mysqli_query ($link, 'SELECT MAX(label_id) FROM labels'); // Search atual label_id for log
				//$array = mysqli_fetch_array($temp);
				$label_id = get_max_id($link);
				log_add($link, $user, $action, $label_id, $fr_addr, $to_addr, $comment);
			}
        }
		else
			return false;
			
    return true;   
}

function lbl_add_csv ($link, $file, $fr_addr, $to_addr) {

	$row = 1;
	$handle = fopen($file, "r");
	
	while( !feof($handle) ){
		$data = fgetcsv($handle, 300, ";");
		$num = count($data); // Number of columns
		
		//echo "<p> $num полей в строке $row: <br /></p>\n";
		//echo "String ".$row." Number of columns " .$num."<br><br>";
		
		$row++;
		
		if($row > 2) {
			$receiver = $data[0];	
			$date_lbl = $data[1];
			$date = date_form ($data[1]);

				
			$part_number = $data[2];
				
			$quantity = $data[3];	
			$quantity = str_replace(" ","",$quantity);
			$quantity = (int)$quantity;
			
			$action = 'add from csv';
			
			$add = lbl_add ($link, $action, $part_number, $quantity, $date, $receiver, $fr_addr, $to_addr);
			$len = get_max_id($link);
			$filepath = lbl_update($part_number,$quantity, $date_lbl, $receiver, $len);
			lbl_print($filepath);			
			//echo $receiver . '  - ' .  $date . ' -  ' . $part_number . '  - ' . $quantity . "<br><br>";
		}
	}
	fclose($handle);
	$labels_added = $row - 2;
	return $labels_added;
}

//  PRINT LABEL TEXT FILE
function lbl_update($part_number, $quantity, $date, $receiver, $label_id){ /* UPDATE LABEL TEXT FILE BASED ON THE FORMAT  */
    $filepath ='label_format.txt';
    $fp = fopen($filepath,'r');
    $filecon = file_get_contents($filepath);
    fclose($fp);

    $label_id = str_pad($label_id, 8, '0', STR_PAD_LEFT);

    $filepath ='rec_label.txt';
    $fp = fopen($filepath,'w');
        $filecon = str_replace('$Part_number$',$part_number,$filecon);
        $filecon = str_replace('$Quantity$',$quantity,$filecon);
        $filecon = str_replace('$Date$',$date,$filecon);
        $filecon = str_replace('$Label_ID$',$label_id,$filecon);
		$filecon = str_replace('$Receiver$',$receiver,$filecon);
    fclose($fp);
	
	$timest = date("d.m.Y H.i.s");
	$filepath = 'F:\Public\4. Logistics\WMS reports\spool'.'\material label '.$label_id.' - '.$timest.'.txt';
	$fp = fopen($filepath,'a');
	fwrite($fp, $filecon);
	fclose($fp);
	
	return $filepath;
}

function lbl_update_wh ($address, $rack, $pallet, $floor){ /* UPDATE warehouse LABEL TEXT FILE BASED ON THE FORMAT  */
    $filepath ='label_format_wh.txt';
    $fp = fopen($filepath,'r');
    $filecon = file_get_contents($filepath);
    fclose($fp);

    //$len = str_pad($len, 8, '0', STR_PAD_LEFT);

    //$filepath ='rec_label.txt';
   // $fp = fopen($filepath,'w');
        $filecon = str_replace('$ADDRESS$',$address, $filecon);
        $filecon = str_replace('$RACK$', $rack,$filecon);
        $filecon = str_replace('$FLOOR$', $floor,$filecon);
        $filecon = str_replace('$PALLET$', $pallet, $filecon);
    //fclose($fp);
	
	$timest = date("d.m.Y H.i.s");
	$filepath = 'F:\Public\4. Logistics\WMS reports\spool'.'\address label '.$address.' - '.$timest.'.txt';
	$fp = fopen($filepath,'a');
	fwrite($fp, $filecon);
	fclose($fp);
	return $filepath;
}

function lbl_print($filepath){

$command = 'print /D:,,10.55.176.61,test_printer2 "'.$filepath.'"';
$command=str_replace(",","\'",$command); 
$command=str_replace("'","",$command); 

shell_exec($command);

return $command;
}

//______________ GET FUNCTIONS ______________
function get_max_id($link){
	$temp = mysqli_query ($link, 'SELECT MAX(label_id) FROM labels'); // Search atual label_id for log
    $array = mysqli_fetch_array($temp);
    $len = (int)$array[0];
	return $len;
}

function get_lbl_string ($link, $label_id) { /* Get assoc. array from labels table for exact label ID */
    $q = 'SELECT * FROM labels WHERE label_id = "%s"';
    $query = sprintf($q, $label_id);
        
    $result = mysqli_query($link, $query);
	
    if(!$result)
        die(mysqli_error($link));
	
    $n = mysqli_num_rows($result);
    $label = array();
	
    for($i = 0; $i < $n; $i++){
		$temp = mysqli_fetch_assoc($result);
		$label[] = $temp; 
    }
  return $label;  }

function get_lbl_fr_barcode ($barcode){ /* Get label ID value from barcode */
    $arr = explode (";", $barcode);
    // first character is 'm'
    if($arr[0] != 'm') { 
		$err_msg = "WRONG LABEL BARCODE!";
		require_once("./views/error.php");
	}
    else
		return $arr[1];
}

function get_addr_fr_barcode ($barcode){ /* Get addreess value from barcode */
    $arr = explode (";", $barcode);
    // first character is 'a'
    if($arr[0] != 'a') { 
        $err_msg = "WRONG ADDRESS BARCODE!";
        require_once("./views/error.php");}
    else	
		return $arr[1];    
}

function get_lbl_arr ($link) { /* Get all labels from warehouse table to assoc. array */
    $query = 'SELECT * FROM labels ORDER BY address, part_number';
    $result = mysqli_query($link, $query);
    if(!$result)
        die(mysqli_error($link));
    $n = mysqli_num_rows($result);
    $labels = array();
    
    for($i = 0; $i < $n; $i++){
    $temp = mysqli_fetch_assoc($result);
    $labels[] = $temp; 
         
    }
  return $labels;  }

function get_addr_arr ($link) { /* Get all addreesses from warehouse table to assoc. array  */
    $query = 'SELECT * FROM warehouse ORDER BY rack, floor DESC, pallet';
    $result = mysqli_query($link, $query);
    if(!$result)
        die(mysqli_error($link));
    $n = mysqli_num_rows($result);
    $address_arr = array();
    
    for($i = 0; $i < $n; $i++){
    $temp = mysqli_fetch_assoc($result);
    $address_arr[] = $temp; 
        
    }
  return $address_arr;  }

function get_rack($link, $address){
    $q = 'SELECT rack FROM warehouse WHERE address = "%s"';
    $query = sprintf($q, (string)$address);
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $array = mysqli_fetch_array($result);
    $rack = (int)$array[0];
    return $rack;
}

function get_floor($link, $address){
    $q = 'SELECT floor FROM warehouse WHERE address = "%s"';
    $query = sprintf($q, (string)$address);
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $array = mysqli_fetch_array($result);
    $floor = (int)$array[0];
    return $floor;
}

function get_pallet($link, $address){
    $q = 'SELECT pallet FROM warehouse WHERE address = "%s"';
    $query = sprintf($q, (string)$address);
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $array = mysqli_fetch_array($result);
    $pallet = (int)$array[0];
    return $pallet ;
}

function get_addr($link, $label_id){
    $q = 'SELECT address FROM labels WHERE label_id = "%s"';
    $query = sprintf($q, (string)$label_id);
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $array = mysqli_fetch_array($result);
    $address = $array[0];
    return $address;
}

// ______________ MOVE and SIGN OFF FUNCTIONS ______________
function lbl_move($link, $action, $label_id, $to_addr){
    $user= 'username';
    $comment = 'manual move or sign off';
    $fr_addr = get_addr($link, $label_id);
    
	if($fr_addr != "SIGNED OFF"){
    
		$q = 'UPDATE labels SET address = "%s" WHERE label_id = "%s"';
		$query = sprintf($q, $to_addr, (string)$label_id);
		$result = mysqli_query($link, $query);
		
		if(!$result)
			die(mysqli_error($link));
		else 
			log_add($link, $user, $action, $label_id, $fr_addr, $to_addr, $comment);
        
		$n = mysqli_affected_rows($link);
		//echo $n." labels moved";
		return $n;  
    }
    else {
		$err_msg = "The label(s) is already SIGNED OFF!".'<br>'."Please read system log for more details.";
        require_once("./views/error.php");
		return 0;
    }
}

//______________ LOG FUNCTIONS ______________
function log_add($link, $user, $action, $label_id, $fr_addr, $to_addr, $comment){
    
$label = get_lbl_string($link, $label_id);
$part_number = $label[0]['part_number']; 
$quantity = $label[0]['quantity'];    
     
$timestamp = date("d.m.Y H.i.s");    
    
$q = "INSERT INTO log (timestamp, action, user, label_id, part_number, quantity, fr_addr, to_addr, comment) VALUES('%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s')";

    $query = sprintf($q, $timestamp, $action, $user, $label_id, $part_number, $quantity, $fr_addr, $to_addr, $comment);
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $n = mysqli_affected_rows($link);
    //echo $n." labels moved";
    return $n;        

}

function log_all ($link){

    $query = 'SELECT * FROM log ORDER BY id DESC';
    $result = mysqli_query($link, $query);
    
    if(!$result)
        die(mysqli_error($link));
    
    $n = mysqli_num_rows($result);
    $arr = array();
    
    for($i = 0; $i < $n; $i++){
    $row = mysqli_fetch_assoc($result);
    $arr[] = $row;
    }
        
    return $arr;
}

function search_in_log ($link, $check_str, $date_from, $date_to, $part_number, $label_id){
    
    if($check_str == '000'){
        $err_msg = 'Wrong search criterias';
        require_once("/views/error.php");
    }
    
    $log_sel = log_all ($link);
    $i = 0;
    $result = false;
    $b = array();
    
    
    // Date selection
    if($check_str[0] != 0){
        
        foreach ($log_sel as $a):
            if($a['timestamp'] > $date_from and $a['timestamp'] < $date_to) {
                $b[$i] = $a;
                $i++;
                $result = true;
    }
                          
        endforeach;
		
        if($i > 0)
            $log_sel = $b;
        $i = 0;
        $b = array();
    }
    
     // Part selection              
    if($check_str[1] != 0){
        
        foreach ($log_sel as $a):
            if($a['part_number'] == $part_number){
                $b[$i] = $a;
                $i++;
                $result = true;
            }
        
        endforeach;
		
        if($i > 0)
            $log_sel = $b;
        $i = 0;
        $b = array();
    }
    
     // Label selection
    if($check_str[2] != 0){
        
        foreach ($log_sel as $a):
            if($a['label_id'] == $label_id){
                $b[$i] = $a;
                $i++;
                $result = true;
            }
        
        endforeach;
		
        if($i > 0)
            $log_sel = $b;
        $i = 0;
        $b = array();
    }
    
    if(!$result){
		return 0;
    }

return $log_sel;
}


?>