<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: search by PN in log</title>
        <link rel="stylesheet" href="../style.css">
         
                   
    </head>
    <body>
        
        <h2><a href="index.php">Back to menu</a></h2>
        <br>
        <h1>Search by part number</h1> 
        
        <div class="container">
            <br> 
            <form method="post" name="form1" action="index.php?action=search_pn">

                        <label>Part number
                            <input type="text" name="part_number" value="" class="form-item" required>
                        </label>
<br><br>           
                    <input type="submit" class="btn">
            </form>
			
<script>			
function Focus_on() {
document.form1.part_number.focus();
}
Focus_on();
</script>				
                
        </div>             
    </body>
</html>