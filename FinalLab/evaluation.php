<?php
// Establish database connection
// mysqli_connect('host', 'username', 'password', 'database') is used to connect to the database.
// 'localhost' is the server (in this case, the local machine).
// 'root' is the username, '' (empty string) is the password (for local development, often no password is used).
// 'localUsers' is the database name.
$conn = mysqli_connect('localhost', 'root', '', 'localUsers');

// Check connection
// If the connection fails, an error message will be shown and the script will stop using die().
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the users1 table
// $sql1 contains the SQL query to select all columns (*) from the 'users1' table.
$sql1 = "SELECT * FROM users1";

// Execute the query using mysqli_query() and store the result in $result1.
$result1 = mysqli_query($conn, $sql1);

// Fetch data from the users2 table
// $sql2 contains the SQL query to select all columns (*) from the 'users2' table.
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
        /* Style the table to collapse borders and set full width */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        /* Add padding and borders to table cells */
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        /* Set background color for table headers */
        th {
            background-color: #f2f2f2;
        }
        /* Add space above each heading */
        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Heading for the page -->
    <h1>Quiz Results Evaluation</h1>

    <!-- Section for displaying users1 data (Passed Users) -->
    <h2>Passed Users</h2>
    <table>
        <tr>
            <!-- Table headers for ID, Name, and Score -->
            <th>ID</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
        <?php
        // Check if there are any rows in $result1
        // mysqli_num_rows() returns the number of rows in the result set
        if (mysqli_num_rows($result1) > 0) {
            // Loop through each row and display it
            // mysqli_fetch_assoc() fetches a row as an associative array
            while ($row1 = mysqli_fetch_assoc($result1)) {
                echo "<tr>";
                echo "<td>" . $row1['Id'] . "</td>"; // Display user ID
                echo "<td>" . $row1['userName'] . "</td>"; // Display user Name
                echo "<td>" . $row1['score'] . "</td>"; // Display user Score
                echo "</tr>";
            }
        } else {
            // If no data is found, display a message
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>

    <!-- Section for displaying users2 data (Users to Retake the Quiz) -->
    <h2>Users to Retake the Quiz</h2>
    <table>
        <tr>
            <!-- Table headers for ID, Name, and Score -->
            <th>ID</th>
            <th>Name</th>
            <th>Score</th>
        </tr>
        <?php
        // Check if there are any rows in $result2
        if (mysqli_num_rows($result2) > 0) {
            // Loop through each row and display it
            while ($row2 = mysqli_fetch_assoc($result2)) {
                echo "<tr>";
                echo "<td>" . $row2['Id'] . "</td>"; // Display user ID
                echo "<td>" . $row2['userName'] . "</td>"; // Display user Name
                echo "<td>" . $row2['score'] . "</td>"; // Display user Score
                echo "</tr>";
            }
        } else {
            // If no data is found, display a message
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>

    <?php
    // Close the database connection to free up resources
    mysqli_close($conn);
    ?>
</body>
</html>
