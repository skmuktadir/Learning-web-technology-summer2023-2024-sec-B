<?php
session_start();

// Function to validate ID format
function validateID($id) {
    // Expected format: YY-XXXXX-Z (e.g., 21-44989-2)
    return preg_match('/^\d{2}-\d{5}-\d$/', $id);
}

// Initialize variables
$cookie_name = "borrowed_book";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $id = $_POST['id'];
    $book = $_POST['book'];
    $borrowing_date = $_POST['borrowing-date'];
    $return_date = date('Y-m-d', strtotime($borrowing_date . ' + 7 days'));

    // Validate ID format
    if (!validateID($id)) {
        echo "Invalid ID format. ID should be in the format YY-XXXXX-Z (e.g., 21-44989-2)";
    } else {
        // Checking if student has already borrowed a book within the last 7 days
        if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == $id) {
            echo "You have already borrowed a book. Please wait 7 days before borrowing another book.";
        } else {
            // Set cookie for 7 days (student ID)
            setcookie($cookie_name, $id, time() + (7 * 24 * 60 * 60));
            echo "Book borrowed successfully!<br>";
            echo "Username: $username<br>";
            echo "Student ID: $id<br>";
            echo "Book: $book<br>";
            echo "Borrowing Date: $borrowing_date<br>";
            echo "Return Date: $return_date<br>";

            // Store session details if needed
            /*$_SESSION['uname'] = $username;
            $_SESSION['book'] = $book;
            $_SESSION['borrowing_date'] = $borrowing_date;
            $_SESSION['return_date'] = $return_date;*/
        }
    }
}

// Display session details (if using session)
/*
if (isset($_SESSION['uname'])) {
    echo "<br>Hello <br> <p style=\"color:red\">" . $_SESSION['uname'] . "</p>";
    echo "Book: " . $_SESSION['book'] . "<br>";
    echo "Borrowing Date: " . $_SESSION['borrowing_date'] . "<br>";
    echo "Return Date: " . $_SESSION['return_date'] . "<br>";
}
*/
?>
<br>
<a href="process.php">REFRESH</a>
<br>
<a href="index.php">BACK TO INDEX PAGE</a>