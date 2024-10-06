<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Redirect if not logged in or not an admin
    header('Location: login.html');
    exit();
}


// Admin result viewing logic
$conn = mysqli_connect('localhost', 'root', '', 'localUsers');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql1 = "SELECT * FROM users1";

$result1 = mysqli_query($conn, $sql1);

$sql2 = "SELECT * FROM users2";

// Execute the query using mysqli_query() and store the result in $result2.
$result2 = mysqli_query($conn, $sql2);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results Evaluation</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Quiz Results Evaluation</h1>

    <h2>Student Result</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
        <?php
        if (mysqli_num_rows($result1) > 0) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                echo "<tr>";
                echo "<td>" . $row1['Id'] . "</td>"; // Display user ID
                echo "<td>" . $row1['userName'] . "</td>"; // Display user Name
                echo "<td>" . $row1['score'] . "</td>"; // Display user Score
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>

    

    <?php
    mysqli_close($conn);