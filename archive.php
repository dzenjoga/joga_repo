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
/*
$label_id = 851;
$label_id = str_pad($label_id, 8, '0', STR_PAD_LEFT);
echo $label_id;



$address = '01.01.01';$label_id = '';
//echo date("d.m.Y H.i.s");
$date_from = '';//'10.11.2015';
$date_to = '16.11.2015';

$arr = log_all ($link);
$i = 0;
if ($date_from > 0 and $date_to > 0){
	foreach ($arr as $a):
			if ($a['timestamp'] > $date_from and $a['timestamp'] < $date_to)
				$arr2[$i] = $a[$i]; 
	endforeach
}
if ($part_number > 0){
	foreach ($b as $a):
			if ($a['timestamp'] > $date_from and $a['timestamp'] < $date_to)
				$arr2[$i] = $a[$i]; 
	endforeach
}
if ($address > 0 and $date_to > 0){
	foreach ($arr as $a):
			if ($a['timestamp'] > $date_from and $a['timestamp'] < $date_to)
				$arr[$i] = $a[$i]; 
	endforeach
}
foreach ($arr as $a):
		echo "Timestamp: ".$a['timestamp']."Label ID: ".$a['label_id']."   Quantity: ".$a['quantity']."  Receiving date: ".$a['date']."<br>";
endforeach

/*
echo time().'<br>';
echo mktime().'<br>';
//echo strtotime().'<br>';
echo date("d.m.Y_H.i.s").'<br>';

$label_id = 11;
$address = get_addr($link,$label_id);
echo '<br><br>'.$address;
echo '<br><br>';


$temp = mysqli_query ($link, 'SELECT MAX(label_id) FROM labels');
$array = mysqli_fetch_array($temp);
$label_id = (string)$array[0];
*



function get_lbl_id ($barcode){
    $arr = explode (";", $barcode);
    if($arr[0] != 'm')  // first character is 'm'
        return "ERROR #102";
    
    return $arr[1];
}
$barcode = 'm;00000010;100;01.01.2013';
$q = get_lbl_id ($barcode);
echo '<br>'.$q; 

function log_allx ($link){

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
$arr = log_allx ($link);
//print ($arr);
for($j = 0; $j < 10; $j++){
echo $arr[$j]['id'].'<br>';}

$part_number = 'L0111';
$arr = search_pn ($link, $part_number);
$temp = array();
$temp = $arr[1];
$nc = count($temp);
echo $nc."  columnes<br><br>";

$nr = count($arr);
echo $nr."  rows";


$to_addr = 'DROPZON';
//$r = get_addr_fr_barcode ($barcode);

$r = check_addr ($link, $to_addr);
echo $r;

//$err_msg = 'XYU';
//$address = "DROPZANE";
//adr_exist ($link, $address);


$addr_arr = get_addr_arr($link);
$i = 0;
$r = 0;
$f = 0;
$p = 0;
$pn = 0;
$fn = 0;
foreach($addr_arr as $a):
        //$i++;
        //echo $i."   ";
        if ($a['rack'] == 0){
            echo "<br><br>".$a['address']."<br><br>";
            $address = $a['address'];
            $lbl_arr = search_addr($link, $address);
                foreach($lbl_arr as $b):
                    echo "Label ID: ".$b['label_id']."   Quantity: ".$b['quantity']."  Receiving date: ".$b['date']."<br>";
                endforeach;
                            }
        else {if ($a['rack'] != $r){
                echo "<br><br>RACK: ".$a['rack']."<br>";
                $r = $a['rack'];
                    }
        if ($a['floor'] != $f){
                    echo "<br>".$a['address']."     ";
                    $f = $a['floor'];
                                }
                else
                    echo $a['address']."     ";
        
                    
             }
endforeach

$rn = 0;
$arr =  array();

foreach($labels as $a):

    $address = $a['address'];
    $rack = get_rack($link, $address );
    $floor = get_floor($link, $address );
    $pallet = get_pallet($link, $address );
        
    $arr[$rack][$floor][$pallet] = $a;
    //echo $arr[$rack][$floor][$pallet]['part_number'].'<br>';

endforeach;

for($f = 3; $f > 0; $f--){
    echo '<br>FLOOR: '.$f.'<br>';
        for ($p = 1; $p <= 3; $p++){
            echo '<br>PALLET: '.$p.'<br>';
            echo $arr[1][$f][$p]['part_number'].'<br>';
    }
}



$labels = get_lbl_arr($link);

	$timest = date("d.m.Y H.i.s");  
	$filepath = './files/warehouse loading on '.$timest.'.csv';
	$fp = fopen($filepath,'a');
		$wh_str = 'Address;Label_ID;Part_number;Quantity;Receiving date'."\r\n"; 
		$test = fwrite($fp, $wh_str); 
		//if($test) echo 'Данные в файл успешно занесены.';
		//else echo 'Ошибка при записи в файл.';
foreach($labels as $a):
    
				$wh_str = $a['address'].';'.$a['label_id'].';'.$a['part_number'].';'.$a['quantity'].';'.$a['date']."\r\n"; 
				$test = fwrite($fp, $wh_str); 
				//if($test) echo 'Данные в файл успешно занесены.';
				//else echo 'Ошибка при записи в файл.';
		
endforeach;


	
	
	
fclose($fp); //Закрытие файла
	
	
	

*/

/*!!!!!!!!!!!!!!!!!
$row = 1;
$handle = fopen("tmp16993.csv", "r");

while( !feof($handle) ){
	$data = fgetcsv($handle, 300, ";");
    $num = count($data); // Number of strings
    //echo "<p> $num полей в строке $row: <br /></p>\n";
    $row++;
    for ($c=0; $c < $num; $c++) {
		if($row > 2) {
			
			$receiver = $data[0];	
			$date = $data[1];	
			$part_number = $data[2];	
			$quantity = $data[3];	
			$quantity = str_replace(" ","",$quantity);
			$quantity = (int)$quantity;
			
			echo $receiver . '  - ' .  $date . ' -  ' . $part_number . '  - ' . $quantity . "<br />\n";
		}

	}
}
fclose($handle);


$date = "28.11.2015";
$date = date_form ($date);
echo $date;
*/