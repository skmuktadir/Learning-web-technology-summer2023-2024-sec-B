<?php
session_start();
if (isset($_SESSION['uname'])) {
    header('Location: private.php');
    exit();
}
include('header.php'); // Include the header
?>

<div class="my-form">
    <h2>Sign Up</h2>
    <form action="process.php" method="post">
        <label for="uname">Email</label>
        <input type="text" name="uname" placeholder="Enter Email" required>

        <label for="pass">Password</label>
        <input type="password" name="pass" placeholder="Enter Password" required>

        <label for="cpass">Confirm Password</label>
        <input type="password" name="cpass" placeholder="Confirm Password" required>

        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" required>

        <input type="submit" name="submit" value="Sign Up" class="button">
    </form>
</div>

<?php include('footer.php'); // Include the footer ?>
