<?php
session_start();
include('header.php'); // Include the shared header

if (isset($_POST["submit"])) {
    // Check if new password matches confirm password
    if ($_POST["update_password"] == $_POST["update_CP"]) {
        // Sanitize and validate email
        $uname = filter_var($_POST["uname"], FILTER_SANITIZE_EMAIL);
        if (filter_var($uname, FILTER_VALIDATE_EMAIL)) {
            $conn = mysqli_connect('localhost', 'root', '', 'localUsers');

            // Escape inputs to prevent SQL injection
            $uname = mysqli_real_escape_string($conn, $uname);
            $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
            $new_pass = mysqli_real_escape_string($conn, $_POST["update_password"]);

            // Check if the username and DOB match in the database
            $check_user_sql = "SELECT * FROM users WHERE userName = '$uname' AND dob = '$dob'";
            $result = mysqli_query($conn, $check_user_sql);

            if (mysqli_num_rows($result) == 1) {
                // If username and DOB match, update the password
                $update_sql = "UPDATE users SET enpassword = '$new_pass' WHERE userName = '$uname' AND dob = '$dob'";
                if (mysqli_query($conn, $update_sql)) {
                    $_SESSION["uname"] = $uname;
                    echo '<div class="success-message">Password updated successfully! Redirecting you to the private page...</div>';
                    header("refresh: 4; url = private.php");
                } else {
                    echo '<div class="error-message">Error updating password. Please try again.</div>';
                    header("refresh: 2; url = forgotPass.php");
                }
            } else {
                // Username or DOB doesn't match
                echo '<div class="error-message">Your username or Date of Birth does not match our records.</div>';
                header("refresh: 2; url = forgotPass.php");
            }
        } else {
            echo '<div class="error-message">Invalid email format. Please try again.</div>';
            header("refresh: 2; url = forgotPass.php");
        }
    } else {
        echo '<div class="error-message">Passwords do not match. Please try again.</div>';
        header("refresh: 2; url = forgotPass.php");
    }
}

include('footer.php'); // Include the shared footer
?>
