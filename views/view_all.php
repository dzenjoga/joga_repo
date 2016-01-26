<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: warehouse</title>
        <link rel="stylesheet" href="style.css">
          
                   
    </head>
    <body>
        
<h2><a href="index.php">Back to menu</a></h2>
 
<?php
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
?>
                <br>
                <h2><?=$a['address']?></h2>
        
<?php
            $address = $a['address'];
            $lbl_arr = search_addr($link, $address);
                foreach($lbl_arr as $b):
                    echo "Label ID: ".$b['label_id']."  PN: ".$b['part_number']."   Quantity: ".$b['quantity']."  Receiving date: ".$b['date']."<br>";
                endforeach;
                            }
        else {
                if ($r != $a['rack']) {
                $f = 0;
                if($r > 0){
?>
        </tr>
        </table>
        
        
<?php
               }
?>
                <br>
                <h2>RACK: <?=$a['rack']?></h2>
                <table>
                    
<?php
                $r = $a['rack'];
                
                    }
        if ($f != $a['floor']){ 
            if($f > 0){
 ?>
     </tr>                   
<?php
                
            }
            $address = $a['address'];
            $lbl_arr = search_addr($link, $address);
                         
?>  
             <tr class="table_all2">
             <td><?php foreach($lbl_arr as $b):?> Label ID: <?=$b['label_id']?>   PN: <?=$b['part_number']?>   Quantity: <?=$b['quantity']?>   Receiving date: <?=$b['date']?><br><?php endforeach;?></td>
                        
<?php 
            
            $f = $a['floor'];}
            else  {
            $address = $a['address'];
            $lbl_arr = search_addr($link, $address);
            ?>
            <td><?php foreach($lbl_arr as $b):?>Label ID: <?=$b['label_id']?>   PN: <?=$b['part_number']?>   Quantity: <?=$b['quantity']?>   Receiving date: <?=$b['date']?><br><?php endforeach;?></td>
            
<?php        }         
             }
endforeach

?>  
        </tr>
        </table>
                    
    
    </body>
    </html>