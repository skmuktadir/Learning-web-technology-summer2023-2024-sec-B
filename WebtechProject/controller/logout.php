<?php
session_start();

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Remove the status cookie by setting its expiration in the past
    setcookie('status', '', time() - 3600, '/');

    // Redirect to landing page
    header('Location: ../view/landingpage.html');
    exit;
}
?>

<script>
if (confirm("Are you sure you want to log out?")) {
    window.location.href = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?confirm=yes";
} else {
    window.history.back();
}
</script>
