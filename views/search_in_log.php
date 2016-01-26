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
        <h1>Search in log</h1> 
        <br>
        <br>
        <br>
        <br>
        <form action="index.php?action=search_in_log" method="post"> 
            <input type="checkbox" name="date_check" value="1" />
            <label>   Date from    
            <input type="date" name="date_from" value="01.11.2015" />
            </label>
            <label>   Date to
            <input type="date" name="date_to" value="01.11.2015"/>
            </label>
            <br><br>            
            
            <input type="checkbox" name="part_check" value="1" />
            <label>   Part number
			
            <input type="text" name="part_number" value="" class="form-item" >
            </label>
            <br><br>
            
            <input type="checkbox" name="label_check" value="1" />
            <label>   Label ID
			
            <input type="text" name="label_id" value="" class="form-item" >
            </label>
            <br>
            <br>
            <br>
            <input type="submit" name="formSubmit" value="Submit" />
            <br>
        </form>
        
        
            
    </body>
</html>
