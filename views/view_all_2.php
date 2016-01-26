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

$labels = get_lbl_arr($link);

$rn = 0;
$fn = 0;
$pn = 0;
$n = 0;
$address = 0;

foreach($labels as $a):
    $temp_address = $a['address'];

    $rack = get_rack($link, $temp_address );
    $floor = get_floor($link, $temp_address );
    $pallet = get_pallet($link, $temp_address );

    if($rack == 0){
            if($address != $a['address']){
                $address = $a['address'];
                echo $address;           }
                    }
    else { if($rn != $rack)
                echo '<br><br>RACK #'.$rack.'<br>';
            $rn != $rack;
          
            if($fn != $floor)
                echo '<br><br>Floor #'.$floor.'<br>';
            $fn = (int)$floor;

            if($pn != $pallet)
                echo '<br>Pallet #'.$pallet;        
            $pn = (int)$pallet;
          
          
          
         } // close else

echo "  Part number:  ".$a['part_number'];
echo "   Quantity: ".$a['quantity']." ; ";
//echo '<br>';
endforeach;
    

?>
    
    </body>
    </html>