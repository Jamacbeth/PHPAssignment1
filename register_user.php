<?php
session_start();
require_once('database.php');

// Get form inputs
$userName = filter_input(INPUT_POST, 'userName');
$emailAddress = filter_input(INPUT_POST, 'emailAddress');
$password = filter_input(INPUT_POST, 'password');
$confirm_password = filter_input(INPUT_POST, 'confirm_password');

// Basic validation
if (!$userName || !$emailAddress || !$password || !$confirm_password) {
    $_SESSION['register_error'] = "All fields are required.";
    header("Location: register_user_form.php");
    exit;
}

if ($password !== $confirm_password) {
    $_SESSION['register_error'] = "Passwords do not match.";
    header("Location: register_user_form.php");
    exit;
}

// Check if username already exists
$query = "SELECT userID FROM registrations WHERE userName = :userName";
$statement = $db->prepare($query);
$statement->bindValue(':userName', $userName);
$statement->execute();
$existingUser = $statement->fetch();
$statement->closeCursor();

if ($existingUser) {
    $_SESSION['register_error'] = "Username already exists.";
    header("Location: register_user_form.php");
    exit;
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$query = "INSERT INTO registrations (userName, password, emailAddress, failed_attempts, last_failed_login)
          VALUES (:userName, :password, :emailAddress, 0, NULL)";

$statement = $db->prepare($query);
$statement->bindValue(':userName', $userName);
$statement->bindValue(':password', $hashed_password);
$statement->bindValue(':emailAddress', $emailAddress);
$statement->execute();
$statement->closeCursor();

// Success message
$_SESSION['register_success'] = "Registration successful! You can now log in.";
header("Location: login_form.php");
exit;
?>
