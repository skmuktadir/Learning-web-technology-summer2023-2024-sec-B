<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP App - Private Area</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome</h1>
        <p>Hello, you are now logged in</p>
        <p>Username: <b><?php echo htmlspecialchars($_SESSION['uname']); ?></b></p>
        <p>Your Profile Pic:</p>
        <img src="https://media.gcflearnfree.org/content/5ef2084faaf0ac46dc9c10be_06_23_2020/box_model.png" width="550" alt="Profile Picture">
        <nav>
            <a href="index.php" class="button">Home</a>
            <a href="signout.php" class="button">Sign Out</a>
        </nav>
    </div>
</body>
</html>
