<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <?php

            $var1 = $_POST['uname'];
            $var2 = $_POST['fullname'];
            $var3 = $_POST['age'];
            $var4 = $_POST['location'];

            $con = mysqli_connect('localhost', 'root', '', 'demo2');

           $sql = "INSERT INTO info (username, fullname, age, location) VALUES ('$var1', '$var2', '$var3', '$var4')";

          if (isset($_POST['submit']) && mysqli_query($con, $sql)) {

             echo "INSERTED";
          }

          

    ?>
    
    <a href="delete.php"> Delete</a>
</body>
</html>