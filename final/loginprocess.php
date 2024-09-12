<?php
session_start();
if (isset($_SESSION["uname"])) {
    header("Location: private.php");
    exit();
}

if (isset($_POST["submit"])) {
    $uname = $_POST["uname"];
    $pass = $_POST["pass"];
    $conn = mysqli_connect('localhost', 'root', '', 'localUsers');

    $sql = "SELECT * FROM users WHERE userName = '$uname' AND enpassword = '$pass'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $_SESSION["uname"] = $uname;
        echo "<div class='success-message'>You are now redirected. Redirecting...</div>";
        header("refresh: 2; url=private.php");
    } else {
        echo "<div class='error-message'>User not found. Redirecting...</div>";
        header("refresh: 2; url=index.php");
    }
} else {
    echo "<div class='error-message'>Fill in the Username and Password.</div>";
    header("refresh: 2; url=index.php");
}
?>
