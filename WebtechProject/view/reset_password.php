<?php
session_start();
if (!isset($_SESSION['can_reset_password']) || !$_SESSION['can_reset_password']) {
    header('Location: forgot_password.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Reset Password</title>
<link rel="stylesheet" href="../asset/css/info.css" />
<script src="../asset/js/forgotPass.js" defer></script>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0;
  }
  form {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    width: 360px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    box-sizing: border-box;
  }
  legend {
    font-size: 1.5rem;
    font-weight: bold;
    color: #ff6b6b;
    margin-bottom: 1rem;
  }
  h2 {
    color: #333;
    margin-bottom: 1rem;
  }
  label {
    font-weight: 600;
    display: block;
    margin-top: 1rem;
  }
  input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 2px solid #764ba2;
    border-radius: 8px;
    font-size: 1rem;
    box-sizing: border-box;
  }
  input[type="submit"] {
    width: 100%;
    background: linear-gradient(45deg, #ff6b6b, #764ba2);
    border: none;
    padding: 12px 0;
    border-radius: 30px;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    margin-top: 1.5rem;
    transition: all 0.3s ease;
  }
  input[type="submit"]:hover {
    background: linear-gradient(45deg, #764ba2, #ff6b6b);
  }
  a {
    display: block;
    margin-top: 1rem;
    color: #764ba2;
    text-align: center;
    text-decoration: underline;
    font-weight: 600;
  }
  .validation-message {
    font-size: 0.9rem;
    margin-top: 4px;
  }
</style>
</head>
<body>

<form id="resetPasswordForm" method="POST" action="../controller/updatePassword.php" onsubmit="return validateResetPassword()">
  <fieldset>
    <legend>Reset Password</legend>
    <h2>Enter your new password</h2>

    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" required minlength="4" onkeyup="validatePassword()" />
    <p id="passwordMessage" class="validation-message"></p>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required minlength="4" onkeyup="validateConfirmPassword()"/>
    <p id="confirmPasswordMessage" class="validation-message"></p>

    <input type="submit" value="Reset Password" />
    <a href="login.html">Cancel</a>
  </fieldset>
</form>

</body>
</html>
