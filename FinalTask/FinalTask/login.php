<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $password = $_POST['password'];

    $users = [
        'admin' => ['role' => 'admin', 'password' => 'admin123'],
        'student1' => ['role' => 'student', 'password' => 'student123'],
        // Add more users as needed
    ];

    if (isset($users[$id]) && $users[$id]['password'] === $password) {
        // Set session variables based on role
        $_SESSION['role'] = $users[$id]['role'];
        $_SESSION['id'] = $id;
        $_SESSION['user_info'] = $users[$id]; // Store the user info (role, password, etc.)
        //echo "$users[$id]";

        if ($users[$id]['role'] === 'admin') {
            header('Location: Evaluation.php'); // Admin results page
            exit();
        } else {
            header('Location: index.php'); // Student quiz page
            exit();
        }
    } else {
        echo "Invalid ID or Password!";
    }
}
?>
