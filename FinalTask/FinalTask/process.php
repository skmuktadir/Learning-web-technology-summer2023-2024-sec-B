<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture user inputs
    $name = $_POST['name'];
    $id = $_POST['id'];

    // Capture answers from the form checking if it's empty then it will null
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

    // Calculate the score
    $score = 0;
    foreach ($correct_answers as $question => $correct_answer) {
        if (isset($answers[$question]) && $answers[$question] === $correct_answer) {
            $score++;
        }
    }

    $total_questions = count($correct_answers);
    $score_percentage = ($score / $total_questions) * 100;
 
        // Establish database connection
        $conn = mysqli_connect('localhost', 'root', '', 'localUsers');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to insert data
        $sql = "INSERT INTO users1 (Id, userName, score) VALUES ('$id', '$name', '$score')";

        if (mysqli_query($conn, $sql)) {
            echo "Record saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        // Display correct answers
        echo "<h2>Correct Answers:</h2>";
        foreach ($correct_answers as $question => $correct_answer) {
        echo "<p>$question: $correct_answer</p>";
    }

        // Close connection
        mysqli_close($conn);
    
    

    // Display results
    echo "<h1>MCQ Test Result</h1>";
    echo "<p>Name: $name</p>";
    echo "<p>ID: $id</p>";
    echo "<p>Your Score: $score / 10</p>";
    echo "<p>Your Score percentage: $score_percentage %</p>";



    
} else {
    echo "Invalid Request!";
}
?>
