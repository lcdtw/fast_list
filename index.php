<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php header('Content-Type: text/html; charset=gbk'); ?>
    <head>
        <title>Care Cure Herbs Prescription Demo</title>
    </head>
    <body>
        
<form action="split_n.php" id="usrform" method="post">
Patient's Name: <input type="text" name="usrname">
<br>
<br>

<textarea rows="4" cols="50" placeholder="Enter Prescription here..." name="comment" form="usrform" type="text">
</textarea>
<br>

<input type="text" name="bags_of_week" placeholder="Days of usage..." >
  <input type="submit" name="Submit" value="Submit">

</form>


    </body>

</html>