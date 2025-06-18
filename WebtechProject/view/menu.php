<?php
session_start();
require_once('../model/menuModel.php');

if (!isset($_SESSION['status']) || $_SESSION['user']['account_type'] !== 'user') {
    header('Location: login.html');
    exit();
}

$menuItems = getMenuItems();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $itemId = (int)$_POST['item_id'];

    // Find item by ID
    $item = null;
    foreach ($menuItems as $menuItem) {
        if ($menuItem['id'] === $itemId) {
            $item = $menuItem;
            break;
        }
    }

    if ($item) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $cart = &$_SESSION['cart'];

        $found = false;
        foreach ($cart as &$cartItem) {
            if ($cartItem['id'] === $itemId) {
                $cartItem['quantity']++;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $cart[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => 1,
            ];
        }
        // Redirect immediately to avoid form resubmission
        header('Location: cart.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Menu - RestaurantPro</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #fafafa;
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
}
nav a {
    color: white;
    text-decoration: none;
    margin-right: 1rem;
}
main {
    max-width: 1200px;
    margin: auto;
    padding: 2rem;
}
.menu-item {
    background: white;
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.menu-item > div {
    max-width: 70%;
}
.menu-item img {
    max-width: 150px;
    max-height: 150px;
    border-radius: 8px;
    object-fit: cover;
    margin-bottom: 10px;
    margin-right: 1rem;
}
.menu-item button {
    background: #ff6b6b;
    border: none;
    padding: 0.5rem 1rem;
    color: white;
    border-radius: 6px;
    cursor: pointer;
}
.menu-item .info {
    flex-grow: 1;
}
</style>
</head>
<body>

<header>Menu</header>

<nav>
  <a href="home.php">Dashboard</a>
  <a href="cart.php">Cart (<?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0 ?>)</a>
  <a href="profile.php?id=<?= htmlspecialchars($_SESSION['user']['id']) ?>">Profile</a>
  <a href="../controller/logout.php">Logout</a>
</nav>

<main>
  <?php if (empty($menuItems)): ?>
    <p>No menu items available right now.</p>
  <?php else: ?>
    <?php foreach ($menuItems as $item): ?>
      <div class="menu-item">
        <?php if (!empty($item['photo'])): ?>
          <img src="../asset/image/<?= htmlspecialchars($item['photo']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
        <?php else: ?>
          <div style="width:150px; height:150px; background:#ccc; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#666; font-size:0.9rem; margin-right:1rem;">
            No Image
          </div>
        <?php endif; ?>

        <div class="info">
          <h3><?= htmlspecialchars($item['name']) ?></h3>
          <p><?= htmlspecialchars($item['description']) ?></p>
          <p><strong>Price: $<?= number_format($item['price'], 2) ?></strong></p>
          <small>Category: <?= htmlspecialchars($item['category']) ?></small>
        </div>

        <form method="POST" style="margin:0;">
          <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
          <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</main>

</body>
</html>
