<?php
session_start();
require_once 'database.php';

// Get form data
$make      = filter_input(INPUT_POST, 'make');
$model     = filter_input(INPUT_POST, 'model');
$year      = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
$mileage   = filter_input(INPUT_POST, 'mileage', FILTER_VALIDATE_INT);
$dealership_id = filter_input(INPUT_POST, 'dealership_id', FILTER_VALIDATE_INT);


if ($make == null || $model == null || $year == null || $mileage == null || $dealership_id == null) {
    $_SESSION['add_error'] = "Invalid vehicle data. Check all fields and try again.";
    header("Location: add_vehicle_form.php");
    exit();
}


$image_name = null;
$upload_dir = 'uploads/';

if (!empty($_FILES['vehicle_image']['name']) && $_FILES['vehicle_image']['error'] == UPLOAD_ERR_OK) {

    $original_filename = basename($_FILES['vehicle_image']['name']);
    $destination = $upload_dir . $original_filename;

   
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    
    move_uploaded_file($_FILES['vehicle_image']['tmp_name'], $destination);

    
    $image_name = $original_filename;

} else {
   
    $image_name = 'ph.jpg';
}

// Insert into database
$query = 'INSERT INTO vehicles (Make, Model, Year, Mileage, dealership_id, vehicle_image)
          VALUES (:make, :model, :year, :mileage, :dealership_id, :vehicle_image)';

$statement = $db->prepare($query);
$statement->bindValue(':make', $make);
$statement->bindValue(':model', $model);
$statement->bindValue(':year', $year);
$statement->bindValue(':mileage', $mileage);
$statement->bindValue(':dealership_id', $dealership_id);
$statement->bindValue(':vehicle_image', $image_name);
$statement->execute();
$statement->closeCursor();

$_SESSION['add_success'] = "Vehicle added successfully!";
header("Location: add_confirmation.php");
exit();
?>
