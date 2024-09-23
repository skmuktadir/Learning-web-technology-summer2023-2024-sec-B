<?php
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Update user data in the database
    $sql = "UPDATE users SET username = ?, password = ? WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$new_username, $new_password, $_POST['old_username']]);

    if ($stmt->rowCount()) {
        echo "Username and password updated successfully!";
    } else {
        echo "Failed to update user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="source.css">
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="post">
            <input type="text" name="old_username" placeholder="Enter your current username" required>
            <input type="text" name="new_username" placeholder="Enter your new username" required>
            <input type="password" name="new_password" placeholder="Enter your new password" required>
            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
