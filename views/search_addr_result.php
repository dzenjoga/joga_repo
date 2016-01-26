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
        <th colspan="5", align="center" >WMS: Search by address (<?=$address?>)</th>
    </tr> 
   <tr class="header2">
       
        <td>Label ID</td>
        <td>Part number</td>
        <td>Quantity</td>
        <td>Address</td>
        <td>Receiving date</td>

    </tr> 

   <?php
//$tq = 0;    
for($j = 0; $j < $nr; $j++){
            ?>         
    <tr class="table_all2">
	 <?php 
	 $label_id = $arr[$j]['label_id'];
	 $label_id = str_pad($label_id, 8, '0', STR_PAD_LEFT);   
	 ?> 
        <td><?=$label_id?></td>
        <td><?=$arr[$j]['part_number']?></td>
        <td><?=$arr[$j]['quantity']?></td>
        <td><?=$arr[$j]['address']?></td>
        <td><?=$arr[$j]['date']?></td>
    </tr>         
    
<?php
//$tq += $arr[$j]['quantity']; 
}
?>
            
      
    </table>  
    </body>
    </html>