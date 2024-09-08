<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>

<h3>Type the username you want to Show</h3> 
    <form method="post"> 
    <input type="text" name="uname" placehoder="Username"> 
    <input type="submit" name="submit", value="Show">     
    </form>

       <?php
            if (isset($_POST['submit'])) {
                $var1 = $_POST['uname'];
                $con = mysqli_connect('localhost', 'root', '', 'demo2');
                
                $sql= "SELECT fullname, location FROM info WHERE username = '$var1'";

  

                echo "Hi ".mysqli_fetch_assoc(mysqli_query($con, $sql))['fullname']."<br>";
                echo "Location is " .mysqli_fetch_assoc(mysqli_query($con, $sql))['location'];

            }
       ?>
</body>
</html>