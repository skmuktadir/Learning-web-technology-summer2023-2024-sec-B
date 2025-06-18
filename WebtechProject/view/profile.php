<?php
session_start();
require_once('../model/userModel.php');

if (!isset($_SESSION['status'])) {
    header('Location: login.html');
    exit();
}

$user = $_SESSION['user'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); // Optional: allow blank for no change

    // Basic validation (you can expand)
    $errors = [];
    if (strlen($username) < 4) {
        $errors[] = "Username must be at least 4 characters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        // If password blank, keep old password
        if ($password === '') {
            $password = $user['password'];
        } else {
            // Optionally hash password here
            // $password = password_hash($password, PASSWORD_DEFAULT);
        }

        $updated = updateUser($user['id'], $username, $email, $password, $user['account_type']);
        if ($updated) {
            // Update session user info
            $_SESSION['user'] = getUserInfo($username);
            $success = "Profile updated successfully.";
            $user = $_SESSION['user']; // refresh user variable
        } else {
            $errors[] = "Failed to update profile. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Edit Profile - RestaurantPro</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9fafb;
    margin: 0; padding: 0;
  }
  header {
    background: #667eea;
    padding: 1rem 2rem;
    color: white;
    font-size: 1.5rem;
  }
  nav {
    background: #4353b3;
    padding: 1rem 2rem;
    display: flex;
    gap: 1rem;
  }
  nav a {
    color: white;
    text-decoration: none;
    padding: 0.5rem 1rem;
    background: #5668d9;
    border-radius: 5px;
    transition: background 0.3s ease;
  }
  nav a:hover {
    background: #ff6b6b;
  }
  main {
    padding: 2rem;
    max-width: 600px;
    margin: auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
  }
  form label {
    display: block;
    margin-top: 1rem;
    font-weight: 600;
    color: #333;
  }
  form input[type="text"],
  form input[type="email"],
  form input[type="password"] {
    width: 100%;
    padding: 8px 12px;
    margin-top: 6px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
  }
  form button {
    margin-top: 1.5rem;
    padding: 12px 20px;
    background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
  }
  form button:hover {
    background: linear-gradient(45deg, #4ecdc4, #ff6b6b);
  }
  .messages {
    margin-top: 1rem;
  }
  .error {
    color: #e74c3c;
    font-weight: 700;
  }
  .success {
    color: #27ae60;
    font-weight: 700;
  }
</style>
</head>
<body>

<header>RestaurantPro Dashboard</header>

<nav>
  <a href="menu.php">Menu</a>
  <a href="cart.php">Cart</a>
  <a href="order_history.php">Orders</a>
  <a href="../controller/logout.php">Logout</a>
</nav>

<main>
  <h2>Edit Profile</h2>

  <?php if (!empty($errors)): ?>
    <div class="messages error">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php elseif (!empty($success)): ?>
    <div class="messages success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required />

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" required />

    <label for="password">Password <small>(leave blank to keep current)</small></label>
    <input type="password" name="password" id="password" placeholder="New password" />

    <button type="submit">Save Changes</button>
  </form>
</main>

</body>
</html>
