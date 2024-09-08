<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <h3>Type the username you want to delete</h3> 
    <form method="post"> 
    <input type="text" name="uname" placehoder="Username"> 
    <input type="submit" name="submit", value="Delete">     
    </form>
    
    <?php
    if (isset($_POST['submit'])) {
    $var1 = $_POST['uname'];
    $con = mysqli_connect('localhost', 'root', '', 'demo2');
    
    $sql = "DELETE FROM info WHERE username='$var1'";
    
   if (mysqli_query($con, $sql)) {
        echo "DELETED";
   }

    }

    ?>
</body>
</html>