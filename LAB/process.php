<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the data from the form
    $book = $_POST['book'];
    $id = $_POST['id'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Simple validation
    if (!empty($book) && !empty($id) && !empty($contact) && !empty($email)) {
        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Check email domain is from Gmail, Yahoo, or Hotmail
            $allowed_domains = ['gmail.com', 'yahoo.com', 'hotmail.com'];
            $email_domain = substr(strrchr($email, "@"), 1);
            
            if (in_array($email_domain, $allowed_domains)) {
                echo "Success: Book borrowed successfully!";
                // Display the current date and the return date
                date_default_timezone_set('Your/Timezone'); // Set your desired timezone
                $current_date = date('Y-m-d H:i:s');
                $return_date = date('Y-m-d H:i:s', strtotime('+7 days'));

                //echo "<p>Current Date and Time: $current_date</p>";
                echo "<p>Please Return Your Book on Date and Time: $return_date</p>";
            } else {
                echo "Error: Email must be from Gmail, Yahoo, or Hotmail.";
            }
        } else {
            echo "Error: Invalid email format.";
        }
    } else {
        echo "Error: All fields are required.";
    }
} else {
    echo "Error: Invalid request.";
}
?>
