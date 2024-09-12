<?php
if (isset($_POST["submit"])) {
    if ($_POST["pass"] == $_POST["cpass"]) {
        $uname = filter_var($_POST["uname"], FILTER_SANITIZE_EMAIL);

        if (filter_var($uname, FILTER_VALIDATE_EMAIL)) {
            $conn = mysqli_connect('localhost', 'root', '', 'localUsers');

            // Escape input to prevent SQL injection
            $uname = mysqli_real_escape_string($conn, $uname);
            $pass = mysqli_real_escape_string($conn, $_POST["pass"]);
            $dob = mysqli_real_escape_string($conn, $_POST["dob"]);

            // Avoid SQL injection using your method
            $sql = "INSERT INTO users (userName, enpassword, dob) VALUES ('$uname', '$pass', '$dob')";
            if (mysqli_query($conn, $sql)) {
                session_start();
                $_SESSION["uname"] = $uname;
                echo "Registration Accepted<br>";
                header("refresh: 4; url = private.php");
            }
        } else {
            echo "Email format is not correct.";
            header("refresh: 2; url = index.php");
        }
    } else {
        echo "Please make sure both password fields are the same.";
        header("refresh: 2; url = index.php");
    }
} else {
    if (session_status() == PHP_SESSION_NONE) {
        header("location:index.php");
    }
}
?>
