<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>WMS: sign off</title>
        <link rel="stylesheet" href="../style.css">
         
                   
    </head>
    <body>
        
        <h2><a href="index.php">Back to menu</a></h2>
        <br>
        <h1>Sign off</h1> 
        
        <div class="container">
            <br> 
            <form method="post" name="form1" action="index.php?action=sign_off">

                        <label>Label ID
						<br> 
                            <input type="text" name="label_id" value="" class="form-item" required>
                        </label>
<br><br>           
                    <input type="submit" class="btn">
            </form>
<script>
function Focus_on() {
document.form1.label_id.focus();
}
Focus_on();
</script>			
                
        </div>             
    </body>
</html>