<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: move</title>
        <link rel="stylesheet" href="style.css">
		
        
		<script type=text/javascript language=JavaScript>
			 <!--
			function KeyPress(e,element)
		   {
			  var kk = navigator.appName == 'Netscape' ? e.which : e.keyCode;
			  if (kk == 13)
			  {
				 //document.keypressform.elements[element].focus();
				 document.getElementById(element).focus();
				 return false
			  }
			  return true
		   }
			 //-->
		</script>		
                   
    </head>
    <body>
        
    <h2><a href="index.php">Back to menu</a></h2>
        <br>
        <h1>Move</h1> 
        
        <div class="container">
            <br> 
            <form id=0 method="post" name="form1" action="index.php?action=move">

                        <label>Label ID
						<br> 
                            <input id=1 type="text" name="label_id" value="" class="form-item" onKeyPress="return KeyPress(event, 2);" required>
                        </label>
<br><br>       
                        <label>New address
						<br> 
                            <input id=2 type="text" name="address" value="" class="form-item" onKeyPress="if (event.keyCode == 13) document.form1.submit();" required>
                        </label>
<br><br>
                    
            </form> 
	<script>
	
		document.getElementById('0').style.zoom = '200%'; 
		
		function Focus_on() {
			//document.form1.label_id.focus();
			document.getElementById('1').focus();
			}
			Focus_on();
	</script>	

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

				for($j = 0; $j < $n; $j++){
				 
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
                
        </div>             
    </body>
</html>