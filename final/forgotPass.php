<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); // Include the shared header ?>

    <div class="container">
        <div class="my-form">
            <h2>Forgot Password</h2>
            <form action="userVerified.php" method="post">
                <label for="uname">Username (Email)</label>
                <input type="text" name="uname" placeholder="Enter your email" required>

                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" required>

                <label for="update_password">New Password</label>
                <input type="password" name="update_password" placeholder="Enter new password" required>

                <label for="update_CP">Confirm Password</label>
                <input type="password" name="update_CP" placeholder="Confirm new password" required>

                <input type="submit" name="submit" value="Reset Password" class="button">
            </form>
        </div>
    </div>

    <?php include('footer.php'); // Include the shared footer ?>
</body>
</html>
