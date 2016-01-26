<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: search by ADDR</title>
        <link rel="stylesheet" href="../style.css">
         
                   
    </head>
    <body>
        
        <h2><a href="index.php">Back to menu</a></h2>
        <br>
        <h1>Search by address</h1> 
        
        <div class="container">
            <br> 
            <form method="post" name="form1" action="index.php?action=search_addr">

                        <label>Address
						<br> 
                            <input type="text" name="address" value="" class="form-item" required>
                        </label>
<br><br>           
                    <input type="submit" class="btn">
            </form> 
			
<script>			
function Focus_on() {
document.form1.address.focus();
}
Focus_on();
</script>	                
        </div>             
    </body>
</html>