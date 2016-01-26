<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: new</title>
        <link rel="stylesheet" href="../style.css">
          
                   
    </head>
    <body>
        <h2><a href="index.php">Back to menu</a></h2>
        <br>
        <h1>New</h1>
        
        <div class="container">
            <br> 
            <form method="post" name="form1" action="index.php?action=add">

                        <label>Part number
						<br> 
                            <input type="text" name="part_number" value="" class="form-item" required>
                        </label>
<br><br>            
                        <label>Quantity
						<br> 
                            <input type="number" name="quantity" value="" class="form-item" required>
                        </label>
<br><br>
                        <label>Date
						<br> 
                            <input type="date" name="date" value="15.11.2015" class="form-item" required>
                        </label>
<br><br>
						<label>Receiver ID
						<br> 
                            <input type="text" name="receiver" value="" class="form-item" required>
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