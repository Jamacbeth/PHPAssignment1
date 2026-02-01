<?php
session_start();

$make = filter_input(INPUT_POST, 'make');
$model = filter_input(INPUT_POST, 'model');
$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
$mileage = filter_input(INPUT_POST, 'mileage', FILTER_VALIDATE_INT);

require_once('database.php');

// Validate required fields
if ($make == null || $model == null || $year == null || $mileage == null) {
    $_SESSION["add_error"] = "Invalid vehicle data. Check all fields and try again.";
    header("Location: error.php");
    die();
}

// Insert vehicle
$query = 'INSERT INTO vehicles (Make, Model, Year, Mileage)
          VALUES (:make, :model, :year, :mileage)';

$statement = $db->prepare($query);
$statement->bindValue(':make', $make);
$statement->bindValue(':model', $model);
$statement->bindValue(':year', $year);
$statement->bindValue(':mileage', $mileage);
$statement->execute();
$statement->closeCursor();


header("Location: add_confirmation.php");
die();
?>
