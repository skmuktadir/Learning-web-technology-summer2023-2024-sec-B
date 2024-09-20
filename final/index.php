<?php
session_start();
if (isset($_SESSION['uname'])) {
    header('Location: private.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP App - Login</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="loginprocess.php" method="post" class="my-form">

        
            <label for="uname">Username:</label>
            <input type="text" id="uname" name="uname" required>
            
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass" required>
            
            <input type="submit" name="submit" value="Login">
        </form>
        <nav>
            <a href="forgotPass.php">Forgot Password</a>
        </nav>
    </div>
</body>
</html>
