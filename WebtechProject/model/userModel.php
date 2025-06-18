<?php

require_once('db.php');
// remove getConnection function from these files

    function login($username, $password){
        $con = getConnection();
        $sql = "select * from users where username='{$username}' and password='{$password}'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);

        if($count ==1){
            return true;
        }else{
            return false;
        }
    }

    function userExists($username){
        $con = getConnection();
        $sql = "select * from users where username='{$username}'";
        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);

        if($count==0){
            return false;
        }else{
            return true;
        }
    }

    function addUser($username, $email, $password, $account_type, $question, $answer) {
        $con = getConnection();
        // Specify column names to ensure proper mapping
        $sql = "INSERT INTO users (username, email, password, account_type, question, answer) 
                VALUES ('{$username}', '{$email}', '{$password}', '{$account_type}', '{$question}', '{$answer}')";
    
        if (mysqli_query($con, $sql)) {
            return true; // Return true on success
        } else {
            // Log or return the error for debugging
            error_log("Error in addUser: " . mysqli_error($con));
            return false; // Return false on failure
        }
    }
    

    function updateUser($id, $username, $email, $password, $account_type){
        $con = getConnection();
        $sql = "update users SET username='$username', password='$password', email='$email', account_type='{$account_type}' where id='$id'";
        if(mysqli_query($con, $sql)){
            return true;
        } else{
            return false;
        }
    }
/*
    function updatePassword($id, $password){
        $con = getConnection();
        $sql = "update users SET password='$password' where id='$id'";
        if(mysqli_query($con, $sql)){
            return true;
        } else{
            return false;
        }
    }
*/
    function deleteUser($id) {
        $con = getConnection();
        
        mysqli_begin_transaction($con);
        
        try {
            // delete the dependent mails
            $sql_delete_mails = "DELETE FROM mails WHERE receiver_id = $id";
            mysqli_query($con, $sql_delete_mails);
    
            // delete the user
            $sql = "DELETE FROM users WHERE id = $id";
            mysqli_query($con, $sql);
    
            mysqli_commit($con);
            return true;
        } catch (Exception $e) {
            //mysqli_roll_back($con);
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    function getUser($id){
        $con = getConnection();
        $sql = "select * from users where id='{$id}'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function getUserInfo($username){
        $con = getConnection();
        $sql = "select * from users where username='{$username}'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function getAllUser(){
        $con = getConnection();
        $sql = "select * from users";
        $result = mysqli_query($con, $sql);

        $users = [];

        while($row = mysqli_fetch_assoc($result)){
            //print_r($row);
            //echo "<br>";
            array_push($users, $row);
        }
        
        return $users;
    }

    function getUserBalance($userId) {
        $con = getConnection();
        $sql = "SELECT balance FROM users WHERE id='$userId'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['balance'];
    }

    function includeTopBar()
    {
        include '../view/topbar.php';
        renderTopBar();
    }

    function includeBottomBar()
    {
        include '../view/bottombar.php';
        renderBottomBar();
    }

    function addBalance($userId, $amount) {
        $con = getConnection();
        $sql = "UPDATE users SET balance = balance + $amount WHERE id = '$userId'";
        return mysqli_query($con, $sql); // Return true/false based on query execution
    }

    function addNewUser($username, $email, $password, $account_type, $question, $answer) {
        // Get the database connection
        $conn = getConnection(); // Assumes getConnection() returns a valid MySQLi connection object
    
        // Directly insert the values without escaping user input (not recommended)
        $sql = "INSERT INTO users (username, email, password, account_type, question, answer) 
                VALUES ('$username', '$email', '$password', '$account_type', '$question', '$answer')";
    
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn); // Close the connection
            return true; // Return true on success
        } else {
            error_log("Error adding user: " . mysqli_error($conn)); // Log error for debugging
            mysqli_close($conn); // Close the connection
            return false; // Return false on failure
        }
    }
    
    
    function addNotification($recipient, $message) {
        $con = getConnection();
        $sql = "INSERT INTO notifications (username, message, created_at) VALUES ('$recipient', '$message', NOW())";
        mysqli_query($con, $sql);
    }
    
function addNotificationNewUser($username){
    $con = getConnection();
            $message = "New user registered: {$username}";
            $created_at = date('Y-m-d H:i:s');
            $notification_query = "INSERT INTO notifications (message, username, created_at) VALUES ('{$message}', NULL, '{$created_at}')";
            mysqli_query($con, $notification_query);
}
function loginByEmail($email, $password) {
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result) === 1;
}


/*function getUserByEmail($email) {
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email='{$email}'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}*/
function updateUserProfile($userId, $email, $password = null) {
    $con = getConnection();
    if (!$password) {
        $sql = "UPDATE users SET email = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $email, $userId);
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET email = ?, password = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $email, $hashed, $userId);
    }
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    return $result;
}
function getUserByEmail($email) {
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    return $user;
}

function getUserById($id) {
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    return $user;
}

function updatePassword($id, $newPassword) {
    $con = getConnection();
    // Remove the hashing, store plain text password
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'si', $newPassword, $id);
    $exec = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($con);
    return $exec;
}



?>
