<?php
session_start();
require_once('../model/db.php');

if (!isset($_SESSION['status']) || $_SESSION['user']['account_type'] !== 'user') {
    header('Location: login.html');
    exit();
}

$con = getConnection();
if (!$con) {
    die("DB connection failed: " . mysqli_connect_error());
}

$userId = $_SESSION['user']['id'];
$message = '';
$error = '';

// Handle new reservation submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['reservation_date'] ?? '';
    $time = $_POST['reservation_time'] ?? '';
    $guests = intval($_POST['guests'] ?? 1);
    $special_requests = trim($_POST['special_requests'] ?? '');

    // Basic validation
    if (!$date || !$time || $guests < 1) {
        $error = "Please fill all required fields properly.";
    } else {
        $stmt = $con->prepare("INSERT INTO reservations (user_id, reservation_date, reservation_time, guests, special_requests, status) VALUES (?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("issis", $userId, $date, $time, $guests, $special_requests);
        if ($stmt->execute()) {
            $message = "Reservation request submitted! You will receive a confirmation soon.";
        } else {
            $error = "Failed to submit reservation. Please try again.";
        }
        $stmt->close();
    }
}

// Fetch user's existing reservations
$stmt = $con->prepare("SELECT reservation_id, reservation_date, reservation_time, guests, special_requests, status FROM reservations WHERE user_id = ? ORDER BY reservation_date DESC, reservation_time DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$reservations = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Your Reservations - RestaurantPro</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #fafafa;
    margin: 0;
    padding: 2rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
  }
  h1, h2 {
    color: #667eea;
  }
  form {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
  }
  label {
    display: block;
    margin-top: 1rem;
    font-weight: bold;
  }
  input[type="date"],
  input[type="time"],
  input[type="number"],
  textarea {
    width: 100%;
    padding: 8px;
    border: 2px solid #764ba2;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 1rem;
  }
  textarea {
    resize: vertical;
  }
  button {
    margin-top: 1rem;
    background: linear-gradient(45deg, #ff6b6b, #764ba2);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 30px;
    font-size: 1.1rem;
    cursor: pointer;
    box-shadow: 0 5px 15px rgba(255,107,107,0.6);
    transition: all 0.3s ease;
  }
  button:hover {
    box-shadow: 0 8px 20px rgba(255,107,107,0.85);
    transform: translateY(-3px);
  }
  .message {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 5px;
    font-weight: bold;
  }
  .message.success {
    background: #d4edda;
    color: #155724;
  }
  .message.error {
    background: #f8d7da;
    color: #721c24;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }
  th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
  }
  th {
    background: #667eea;
    color: white;
  }
  tr:nth-child(even) {
    background: #f4f7fb;
  }
</style>
</head>
<body>

<h1>Your Reservations</h1>

<?php if ($message): ?>
  <div class="message success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<?php if ($error): ?>
  <div class="message error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="">
  <h2>Book a Table</h2>
  
  <label for="reservation_date">Date *</label>
  <input type="date" id="reservation_date" name="reservation_date" required min="<?= date('Y-m-d') ?>" />
  
  <label for="reservation_time">Time *</label>
  <input type="time" id="reservation_time" name="reservation_time" required />
  
  <label for="guests">Number of Guests *</label>
  <input type="number" id="guests" name="guests" min="1" max="20" value="1" required />
  
  <label for="special_requests">Special Requests</label>
  <textarea id="special_requests" name="special_requests" rows="3" placeholder="Any special requests?"></textarea>
  
  <button type="submit">Submit Reservation</button>
</form>

<h2>Your Upcoming Reservations</h2>

<?php if (empty($reservations)): ?>
  <p>You have no reservations yet.</p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Guests</th>
        <th>Special Requests</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reservations as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['reservation_date']) ?></td>
        <td><?= htmlspecialchars(substr($r['reservation_time'], 0, 5)) ?></td>
        <td><?= htmlspecialchars($r['guests']) ?></td>
        <td><?= nl2br(htmlspecialchars($r['special_requests'])) ?></td>
        <td><?= htmlspecialchars($r['status']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<p><a href="home.php">Back to Dashboard</a></p>

</body>
</html>
