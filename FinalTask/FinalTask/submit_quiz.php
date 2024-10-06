<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header('Location: login.html');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$answers = [
    'q1' => $_POST['q1'] ?? null,
    'q2' => $_POST['q2'] ?? null,
    'q3' => $_POST['q3'] ?? null,
    'q4' => $_POST['q4'] ?? null,
    'q5' => $_POST['q5'] ?? null,
    'q6' => $_POST['q6'] ?? null,
    'q7' => $_POST['q7'] ?? null,
    'q8' => $_POST['q8'] ?? null,
    'q9' => $_POST['q9'] ?? null,
    'q10' => $_POST['q10'] ?? null,
];

// Define the correct answers
$correct_answers = [
    'q1' => 'Au',
    'q2' => 'Nitrogen',
    'q3' => 'Carbon Dioxide',
    'q4' => '7',
    'q5' => 'H2O',
    'q6' => 'Carbon Dioxide',
    'q7' => 'Oganesson',
    'q8' => '-1',
    'q9' => 'Diamond',
    'q10' => 'Sublimation',
];

// Dummy quiz score calculation - In reality, this should be dynamic based on the answers
$user_info = $_SESSION['id'];
//$name = $_SESSION['name'];
//echo "$user_info";
//echo "$name";
$name = $_POST['name'];
//echo "$name";



$score = 0;
    foreach ($correct_answers as $question => $correct_answer) {
        if (isset($answers[$question]) && $answers[$question] === $correct_answer) {
            $score++;
        }
    }

    $total_questions = count($correct_answers);
    $score_percentage = ($score / $total_questions) * 100;
if ($score >= 5) {
    // Passed quiz - save to 'users1' table
    // Insert into the database code for passed students
    $conn = mysqli_connect('localhost', 'root', '', 'localUsers');
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to insert data
        $sql = "INSERT INTO users1 (Id, userName, score) VALUES ('$user_info', '$name', '$score')";

        if (mysqli_query($conn, $sql)) {
            echo "Record saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    echo "Congratulations, you passed!";

} else {

    echo "You need to retake the quiz.";
    // header('Location: retake.php'); // Optionally, redirect to a retake page
}
}
?>
