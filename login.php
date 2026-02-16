<?php
session_start();
date_default_timezone_set("America/Toronto");

require_once('database.php');

// These MUST match your form input names
$user_name = filter_input(INPUT_POST, 'userName');
$user_password = filter_input(INPUT_POST, 'password');

// Fetch user by username
$queryUsers = '
    SELECT userID, userName, password, emailAddress, failed_attempts, last_failed_login 
    FROM registrations 
    WHERE userName = :userName';

$statement = $db->prepare($queryUsers);
$statement->bindValue(':userName', $user_name);
$statement->execute();
$user = $statement->fetch();
$statement->closeCursor();

if ($user) {

    $now = new DateTime();

    // Handle NULL last_failed_login safely
    if ($user['last_failed_login'] !== null) {
        $last_failed = new DateTime($user['last_failed_login']);
        $interval = $now->getTimestamp() - $last_failed->getTimestamp();
    } else {
        $interval = 999999; // no lockout
    }

    // Lockout check
    if ($user['failed_attempts'] >= 3 && $interval < 300) {
        $remaining = 300 - $interval;
        $_SESSION['login_error'] = "Account locked. Try again in " . ceil($remaining) . " seconds.";
        header("Location: login_form.php");
        exit;
    }

    // Verify password
    if (password_verify($user_password, $user['password'])) {

        // Reset failed attempts
        $query = "UPDATE registrations 
                  SET failed_attempts = 0, last_failed_login = NULL 
                  WHERE userName = :userName";
        $statement = $db->prepare($query);
        $statement->bindValue(':userName', $user_name);
        $statement->execute();
        $statement->closeCursor();

        // Set session variables
        $_SESSION['isLoggedIn'] = TRUE;
        $_SESSION['userName'] = $user['userName'];
        $_SESSION['user_id'] = $user['userID'];

        header("Location: login_confirmation.php");
        exit;

    } else {

        // Increment failed attempts
        $query = "UPDATE registrations 
                  SET failed_attempts = failed_attempts + 1, last_failed_login = NOW() 
                  WHERE userName = :userName";
        $statement = $db->prepare($query);
        $statement->bindValue(':userName', $user_name);
        $statement->execute();
        $statement->closeCursor();

        $_SESSION['login_error'] = "Incorrect password.";
        header("Location: login_form.php");
        exit;
    }

} else {
    $_SESSION['login_error'] = "User not found.";
    header("Location: login_form.php");
    exit;
}
?>
