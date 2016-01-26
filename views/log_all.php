<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: Log</title>
        <link rel="stylesheet" href="style.css">
          
                   
    </head>
    <body>
        
<h2><a href="index.php">Back to menu</a></h2>
<br>
<h1>Log</h1> 
        
        
        <table>  
   
    <tr class="header1">
        <th colspan="10", align="center" ><?=$log_header?></th>
    </tr> 
   <tr class="header2">
        <td>ID</td>
        <td>Action</td>
        <td>Date and Time</td>
        <td>User</td>
        <td>Label ID</td>
		<td>Part number</td>
		<td>Quantity</td>
        <td>From address</td>
        <td>To address</td>
        <td>Comment</td>
    </tr> 

   <?php

for($j = 0; $j < $nr; $j++){
	 
	 $label_id = $log[$j]['label_id'];
	 $label_id = str_pad($label_id, 8, '0', STR_PAD_LEFT);   
	
            ?>         
            
    <tr class="table_all2">
        <td><?=$log[$j]['id']?></td>
        <td><?=$log[$j]['action']?></td>
        <td><?=$log[$j]['timestamp']?></td>
        <td><?=$log[$j]['user']?></td>
        <td><?=$label_id?></td>
		<td><?=$log[$j]['part_number']?></td>
		<td><?=$log[$j]['quantity']?></td>
        <td><?=$log[$j]['fr_addr']?></td>
        <td><?=$log[$j]['to_addr']?></td>
        <td><?=$log[$j]['comment']?></td>
    </tr> 
<?php  
                

}


?>
    </table>  
    </body>
    </html>