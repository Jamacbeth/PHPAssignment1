<?php
session_start();
require_once('database.php');

$make = filter_input(INPUT_POST, 'make');
$model = filter_input(INPUT_POST, 'model');
$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
$mileage = filter_input(INPUT_POST, 'mileage', FILTER_VALIDATE_INT);

if ($make == null || $model == null || $year == null || $mileage == null) {
    $_SESSION["delete_error"] = "Invalid vehicle reference.";
    header("Location: index.php");
    exit;
}

$query = 'DELETE FROM vehicles 
          WHERE Make = :make 
          AND Model = :model 
          AND Year = :year 
          AND Mileage = :mileage';

$statement = $db->prepare($query);
$statement->execute([
    ':make' => $make,
    ':model' => $model,
    ':year' => $year,
    ':mileage' => $mileage
]);
$statement->closeCursor();

$_SESSION["delete_success"] = "Vehicle deleted successfully.";

header("Location: delete_vehicle_confirmation.php");
exit;
?>
