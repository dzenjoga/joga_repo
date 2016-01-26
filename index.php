<?php
require_once("database.php");
require_once("models/functions.php");
date_default_timezone_set('Europe/Samara');

$link = db_connect();

//_____ System settings____

	$param_1 = 0;	// Possibility to move from SIGNED OFF location. 1 - Yes, 2 - No
	$param_2 = 1;	// FIFO 1 - On, 2 - Off
	$param_3 = 0;	// Possibility to move the label on location where the label with the same PN and different rec. date is already  located.
	$param_4 = 1;
	$param_5 = 1;
	$param_6 = 1;
	$param_7 = 1;


//_________________________

if(isset($_GET['action']))
    $action = $_GET['action'];
else {
    $action = "";
	if ($_GET['scanner'] == 'true')
		header("Location: ./views/menu_scan.php");
	else
		header("Location: ./views/menu.php");  
}

switch ($action){
    case 'add':         //      _______ADD_______   
        $fr_addr = 'SUPPLIER';
        $to_addr = 'DROPZONE';
        if(!empty($_POST)){ 
			$date_lbl = $_POST['date'];
			$date = date_form ($_POST['date']);
            $add = lbl_add($link, $action, $_POST['part_number'],$_POST['quantity'], $date, $_POST['receiver'], $fr_addr, $to_addr);
			
			if ($add){
				$len = get_max_id($link);
				$filepath = lbl_update($_POST['part_number'],$_POST['quantity'], $date_lbl, $_POST['receiver'], $len) ; 
				$command = lbl_print($filepath);
				//echo $command;
				header("Location: ./views/menu.php");   
            }
			else {
					$err_msg = "PART NUMBER DOESN'T EXIST!";
					require_once("/views/error.php");
			}
            
		}
        else
            require_once("./views/label_add.php");
    break;    
    
	case 'add_csv':         //      _______ADD from CSV_______   
        $fr_addr = 'SUPPLIER';
        $to_addr = 'DROPZONE';
		$file = 'F:\Public\4. Logistics\WMS reports\load'.'\receiving.csv';
		
		$err = check_part_csv ($link, $file);
		
		if ($err > 0){
			$err_msg = $err." part number(s) in file ".$file." don't exist in the database!";
			require_once("/views/error.php");
		}
		else {
			$nr = lbl_add_csv ($link, $file, $fr_addr, $to_addr);
			$log_header =  $nr.' labels added from '.$file; 
			$log = log_all($link);
			require_once("./views/log_all.php");
		}
		      
    break; 
	
    case 'move':         //      _______MOVE_______      
           if(!empty($_POST)){
				
				$label_id = get_lbl_fr_barcode ($_POST['label_id']);
				$to_addr = get_addr_fr_barcode ($_POST['address']);
               
               // Address value check
				$ch_res = check_addr ($link, $to_addr);
				if ($ch_res > 0){                
                       $n = lbl_move($link, $action, $label_id,  $to_addr);
					   
				//if ($_GET['scanner'] == 'true'){
				//	header("Location: ./views/menu_scan.php");
				//}
				//else
					$log_header =  $n.' last entries from log'; 
					require_once("/views/label_move2.php");
					//header("Location: ./views/menu.php");
				}
				else {
					$err_msg = "ADDRESS DOESN'T EXIST!";
					require_once("/views/error.php");
				}
            }
            else {
				if ($_GET['scanner'] == 'true')
					require_once("/views/scan_move.php");
				else {
					$n = 10;
					$log_header =  $n.' last entries from log'; 
					$log = log_all($link);
					require_once("/views/label_move2.php");
				}	
			}   
				
    break;
	
	
	case "move_batch":  	//      _______BATCH MOVE_______   change this mess ASAP!!!
			// echo "!!!!";
            if(!empty($_POST)){ 
			
				$to_addr = get_addr_fr_barcode ($_POST['address']); 
				
				$ch_res = check_addr ($link, $to_addr); // Address value check
				if ($ch_res > 0){						// Address value check
				
					for( $i = 1; $i < 11 ; $i++ ){ 
						if (($_POST['label_id_'.$i]) != null){
							$labels[$i] = get_lbl_fr_barcode ($_POST['label_id_'.$i]);
							$label_id = $labels[$i];
							//echo $action."  ".$label_id."  ".$to_addr.'<br>';
							$n = lbl_move($link, $action, $label_id,  $to_addr);
						}
					}
					require_once("./views/label_move_batch.php");
				}
				
				else {
					$err_msg = "ADDRESS DOESN'T EXIST!";
					require_once("/views/error.php");
				}
			}
			else {
				require_once("./views/label_move_batch.php");
			}	
    break;
    
        
    case 'view':        //      _______VIEW_______
        if(!empty($_POST))        
            lbl_view($link,$_POST['label_id'],  $_POST['address']);
        else    require_once("./views/view_all.php");
    break;
	
	case 'view_csv':        //      _______VIEW CSV_______
         view_wh_csv ($link);     
         header("Location: ./views/menu.php");  
    break;
	
   
    case 'log':         //      _______LOG_______
           if(!empty($_POST)) {
               $log = log_all($link);
               $nr = $_POST['nr'];   // not finished yet            
               require_once("./views/log_last.php");
           }
           else    { 
                $log = log_all($link);
                //$nr = count($log);
				$nr = 500;
				$log_header = 'Log (last '.$nr.' entries)'; 
                require_once("./views/log_all.php");}
    break;
    
    case 'sign_off':   //      _______SIGN OFF_______     
            if(!empty($_POST)){
                $label_id = get_lbl_fr_barcode ($_POST['label_id']);
                $to_addr = 'SIGNED OFF';
                               
                if ($label_id != 'ERROR'){                
                       $n = lbl_move($link, $action, $label_id, $to_addr);
					   
						if ($_GET['scanner'] == 'true')
							header("Location: ./views/menu_scan.php");
						else
							header("Location: ./views/menu.php");
                       
               }
               else require_once("/views/error.php");
                   }
                
             else   {
				if ($_GET['scanner'] == 'true')
					require_once("./views/scan_sign_off.php");
				else
					require_once("./views/label_sign_off.php");
			 }
				
    break;
    
    case 'search_pn':   //      _______SEARCH PN_______ 
           if(!empty($_POST)) {
                $part_number = $_POST['part_number'];
                $arr = search_pn ($link, $part_number);
                $nr = count($arr);
                require_once("./views/search_pn_result.php"); 
           }
           else     
                require_once("./views/search_pn.php");
    break;
        
    case 'search_addr':   //      _______SEARCH ADDR_______ 
           if(!empty($_POST)) {
                $address = $_POST['address'];
                $arr = search_addr ($link, $address);
                $nr = count($arr);
                require_once("./views/search_addr_result.php"); 
           }
           else     
                require_once("./views/search_addr.php");
    break;
	
	case 'search_pn':   //      _______SEARCH PN_______ 
           if(!empty($_POST)) {
                $part_number = $_POST['part_number'];
                $arr = search_pn ($link, $part_number);
                $nr = count($arr);
                require_once("./views/search_pn_result.php"); 
           }
           else     
                require_once("./views/search_pn.php");
    break;
	
	case 'search_in_log':  //      _______SEARCH IN LOG_______ 
           if(!empty($_POST)) {
               $date_from = $_POST['date_from'];
               $date_to = $_POST['date_to'];
               $part_number = $_POST['part_number'];
               $label_id = $_POST['label_id'];
               
               if(!isset($_POST['date_check']) or !isset($_POST['date_from']) or !isset($_POST['date_to']))
    $_POST['date_check'] = 0;
               if(!isset($_POST['part_check']) or !isset($_POST['part_number']))
    $_POST['part_check'] = 0;
               if(!isset($_POST['label_check']) or !isset($_POST['label_id']))
    $_POST['label_check'] = 0;
               $check_str = (string)$_POST['date_check'].$_POST['part_check'].$_POST['label_check'];		
               $log = search_in_log ($link, $check_str, $date_from, $date_to, $part_number, $label_id);
			   $nr = count($log);
			   
				   if ($log  != 0){
					   $log_header = 'Search in log ('.$nr.' entries found)'; 
					   require_once("./views/log_all.php");
					   //require_once("./views/search_in_log_result.php");
				   }
				   else{
					    $err_msg = 'With these search criterias result is nothing';
						require_once("/views/error.php");
				   }
           }
           else    
                require_once("./views/search_in_log.php");
    break;   
	
        
}

?>