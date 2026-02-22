<?php
session_start();
require_once('database.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== TRUE) {
    $_SESSION['finance_error'] = "You must be logged in to apply for financing.";
    header("Location: login_form.php");
    exit;
}

$fullName = filter_input(INPUT_POST, 'fullName');
$email = filter_input(INPUT_POST, 'email');
$phone = filter_input(INPUT_POST, 'phone');
$income = filter_input(INPUT_POST, 'income', FILTER_VALIDATE_INT);
$employmentStatus = filter_input(INPUT_POST, 'employmentStatus');
$creditScore = filter_input(INPUT_POST, 'creditScore', FILTER_VALIDATE_INT);
$message = filter_input(INPUT_POST, 'message');

$userID = $_SESSION['userID'] ?? null;

if (!$fullName || !$email || !$phone || !$income || !$employmentStatus || !$creditScore) {
    $_SESSION['finance_error'] = "All required fields must be filled out.";
    header("Location: financing_form.php");
    exit;
}
<link rel="stylesheet" type="text/css" href="css/global.css">

$query = "INSERT INTO financing_applications
            (userID, fullName, email, phone, income, employmentStatus, creditScore, message, status)
          VALUES
            (:userID, :fullName, :email, :phone, :income, :employmentStatus, :creditScore, :message, 'Pending')";

$statement = $db->prepare($query);
$statement->bindValue(':userID', $userID);
$statement->bindValue(':fullName', $fullName);
$statement->bindValue(':email', $email);
$statement->bindValue(':phone', $phone);
$statement->bindValue(':income', $income);
$statement->bindValue(':employmentStatus', $employmentStatus);
$statement->bindValue(':creditScore', $creditScore);
$statement->bindValue(':message', $message);
$statement->execute();
$statement->closeCursor();

$_SESSION['finance_success'] = "Your financing application has been submitted for review!";

header("Location: financing_form.php");
exit;
?>
