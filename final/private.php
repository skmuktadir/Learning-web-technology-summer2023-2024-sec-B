<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP APP</title>
    <style>
        /* Container for book options */
        .book-option {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .book-option img {
            width: 120px; /* Adjust the size of the book images */
            height: auto;
            margin-left: 10px; /* Add some space between the label and the image */
        }

        .book-option label {
            font-weight: bold;
            margin-left: 10px;
        }

        /* General form styling */
        form {
            margin-top: 20px;
        }

        form input[type="text"],
        form input[type="date"] {
            width: 50%; /* Adjust width to make it more visually balanced */
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Additional styling */
        a {
            margin-right: 20px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <p style="text-align:left">
        Hello, you are now logged in<br>
        Username: <b style="color:red"><?php echo $_SESSION['uname']; ?></b><br>
        <br>Your Profile Pic:<br>
        <img src="https://media.gcflearnfree.org/content/5ef2084faaf0ac46dc9c10be_06_23_2020/box_model.png" width="250">
    </p>
    <br>
    <h2>Borrow Book</h2>
    <form action="bookBrrow.php" method="post">
        <label for="username">Your name</label>
        <input type="text" name="username" placeholder="Username" required><br><br>

        <label for="id">Your ID</label>
        <input type="text" name="id" placeholder="ID" required><br><br>

        <label for="borrowing-date">Borrowing Date</label>
        <input type="date" id="borrowing-date" name="borrowing-date" required><br><br>

        <h2>Choose a book</h2><br>

        <div class="book-option">
            <input type="radio" id="book1" name="book" value="Atomic Habits" required>
            <label for="book1">Atomic Habits</label>
            <img src="AtomicHabits.png" alt="Atomic Habits">
        </div>

        <div class="book-option">
            <input type="radio" id="book2" name="book" value="The Housemaid Is Watching" required>
            <label for="book2">The Housemaid Is Watching</label>
            <img src="The_Housemaid_Is_Watching.png" alt="The Housemaid Is Watching">
        </div>

        <div class="book-option">
            <input type="radio" id="book3" name="book" value="Suicide Med" required>
            <label for="book3">Suicide Med</label>
            <img src="SuicideMed.png" alt="Suicide Med">
        </div>

        <input type="submit" name="submit" value="Submit">
    </form>
    <a href="index.php">Home</a>
    <a href="signout.php">Sign Out</a>
</body>
</html>
