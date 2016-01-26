<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: move</title>
        <link rel="stylesheet" href="../style.css">
        
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
        

        
        <div class="container">
			
            <form id=0 method="post" name="form1" action="index.php?action=move&scanner=true">
			<h2><a href="index.php?scanner=true">Back to menu</a></h2>
			<h2>Move</h2> 
            

                        <label>Label ID
						<br> 
                            <input id=1 type="text" name="label_id" value="" class="form-item" onKeyPress="return KeyPress(event, 2);" required >
                        </label>
<br><br>       
                        <label>New address
						<br> 
                            <input id=2 type="text" name="address" value="" class="form-item" onKeyPress="if (event.keyCode == 13) document.form1.submit();" required>
                        </label>
            
            </form> 
	<script>
	
		document.getElementById('0').style.zoom = '125%'; 
		
		function Focus_on() {
			//document.form1.label_id.focus();
			document.getElementById('1').focus();
			}
			Focus_on();
	</script>			
                
        </div>             
    </body>
</html>