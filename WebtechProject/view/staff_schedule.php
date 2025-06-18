<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['status']) || $_SESSION['user']['account_type'] !== 'admin') {
    header('Location: login.html');
    exit();
}

require_once('../model/db.php');
require_once('../model/staffModel.php');
$conn = getConnection();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_name = $_POST['staff_name'];
    $role = $_POST['role'];
    $shift_date = $_POST['shift_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $stmt = $conn->prepare("INSERT INTO staff_schedule (staff_name, role, shift_date, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $staff_name, $role, $shift_date, $start_time, $end_time);
    $stmt->execute();
    $stmt->close();
}

// Fetch all schedules
$result = $conn->query("SELECT * FROM staff_schedule ORDER BY shift_date, start_time");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Staff Scheduling - RestaurantPro</title>
  <link rel="stylesheet" href="../asset/css/landingpage.css" />
  <style>
    main {
      max-width: 1000px;
      margin: 100px auto 50px;
      background: #fff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    h1 {
      margin-bottom: 1rem;
    }
    form {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }
    input, select, button {
      padding: 10px;
      font-size: 1rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #4ecdc4;
      color: #fff;
    }
    tr:hover {
      background: #f9f9f9;
    }
  </style>
</head>
<body>

<header>
  <div class="header-content">
    <div class="logo">Admin Panel - RestaurantPro</div>
    <div class="nav-buttons">
      <a href="home.php" class="nav-btn">Dashboard</a>
      <a href="userlist.php" class="nav-btn">Users</a>
      <a href="menu_management.php" class="nav-btn">Menu</a>
      <a href="order_management.php" class="nav-btn">Orders</a>
      <a href="reservation_management.php" class="nav-btn">Reservations</a>
      <a href="staff_schedule.php" class="nav-btn active">Staff Schedule</a>
      <a href="../controller/logout.php" class="nav-btn">Logout</a>
    </div>
  </div>
</header>

<main>
  <h1>Staff Scheduling</h1>

  <form method="POST" action="staff_schedule.php">
    <input type="text" name="staff_name" placeholder="Staff Name" required>
    <select name="role" required>
      <option value="">Select Role</option>
      <option value="Chef">Chef</option>
      <option value="Waiter">Waiter</option>
      <option value="Manager">Manager</option>
      <option value="Cleaner">Cleaner</option>
    </select>
    <input type="date" name="shift_date" required>
    <input type="time" name="start_time" required>
    <input type="time" name="end_time" required>
    <button type="submit">Assign Shift</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>Staff Name</th>
        <th>Role</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>End Time</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['staff_name']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td><?= htmlspecialchars($row['shift_date']) ?></td>
            <td><?= htmlspecialchars($row['start_time']) ?></td>
            <td><?= htmlspecialchars($row['end_time']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="5">No staff schedule found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

</body>
</html>
