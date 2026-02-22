<link rel="stylesheet" type="text/css" href="css/global.css">

<?php
session_start();
require_once('database.php');

// Ensure user is logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== TRUE) {
    $_SESSION['sell_error'] = "You must be logged in to sell a vehicle.";
    header("Location: login_form.php");
    exit;
}

// Get form inputs
$make = filter_input(INPUT_POST, 'make');
$model = filter_input(INPUT_POST, 'model');
$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
$mileage = filter_input(INPUT_POST, 'mileage', FILTER_VALIDATE_INT);
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description');

$userID = $_SESSION['userID'];

// Validate
if (!$make || !$model || !$year || !$mileage || !$price || !$description) {
    $_SESSION['sell_error'] = "All fields are required.";
    header("Location: sell_vehicle_form.php");
    exit;
}

// Insert submission
$query = "INSERT INTO user_submissions 
            (userID, make, model, year, mileage, price, description, status)
          VALUES 
            (:userID, :make, :model, :year, :mileage, :price, :description, 'Pending')";

$statement = $db->prepare($query);
$statement->bindValue(':userID', $userID);
$statement->bindValue(':make', $make);
$statement->bindValue(':model', $model);
$statement->bindValue(':year', $year);
$statement->bindValue(':mileage', $mileage);
$statement->bindValue(':price', $price);
$statement->bindValue(':description', $description);
$statement->execute();
$statement->closeCursor();

// Success message
$_SESSION['sell_success'] = "Your vehicle has been submitted for review!";

// Redirect to confirmation page
header("Location: sell_confirm.php");
exit;
?>
