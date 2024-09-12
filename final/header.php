<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>PHP App</h1>
            <nav>
                <a href="index.php">Home</a> |
                <a href="signup.php">Sign Up</a> |
                <a href="forgotPass.php">Forgot Password</a>
                <?php if (isset($_SESSION['uname'])): ?>
                    | <a href="private.php">Private</a> |
                    <a href="signout.php">Sign Out</a>
                <?php endif; ?>
            </nav>
        </header>
        <hr>
