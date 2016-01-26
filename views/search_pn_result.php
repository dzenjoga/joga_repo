<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: search result</title>
        <link rel="stylesheet" href="./style.css">
          
                   
    </head>
    <body>
        
<h2><a href="./index.php">Back to menu</a></h2>
<br>
<h1>Search</h1> 
        
        
        <table>  
   
    <tr class="header1">
        <th colspan="4", align="center" >WMS: Search by part number (<?=$part_number?>)</th>
    </tr> 
   <tr class="header2">
       
        <td>Label ID</td>
        <td>Quantity</td>
        <td>Address</td>
        <td>Receiving date</td>

    </tr> 

   <?php
$tq = 0;    
for($j = 0; $j < $nr; $j++){
     if($arr[$j]['address'] != 'SIGNED OFF'){    
		$label_id = $arr[$j]['label_id'];
		$label_id = str_pad($label_id, 8, '0', STR_PAD_LEFT);  


	 ?>         
    <tr class="table_all2">
	
        <td><?=$label_id?></td>
        <td><?=$arr[$j]['quantity']?></td>
        <td><?=$arr[$j]['address']?></td>
        <td><?=$arr[$j]['date']?></td>
    </tr>         
    
	 <?php }
	if($arr[$j]['address'] != 'SIGNED OFF')
		$tq += $arr[$j]['quantity']; 
}
?>
            
            
        <tr class="header1">
       
            <td colspan="4">Total quantity: <?=$tq?></td>
        
        </tr>     
            
    </table>  
    </body>
    </html>