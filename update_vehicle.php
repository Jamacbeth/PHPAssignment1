<?php
session_start();
require_once 'database.php';

$id       = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$make     = filter_input(INPUT_POST, 'make', FILTER_SANITIZE_STRING);
$model    = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
$year     = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
$mileage  = filter_input(INPUT_POST, 'mileage', FILTER_VALIDATE_INT);
$oldImage = $_POST['old_image'] ?? 'ph.jpg';

if (!$id) {
    $_SESSION['error'] = "Invalid vehicle ID.";
    header("Location: index.php");
    exit();
}

$imageName = $oldImage;
$uploadDir = "uploads/";
$placeholder = "ph.jpg";

// If a new image was uploaded
if (!empty($_FILES['vehicle_image']['name'])) {

    $file = $_FILES['vehicle_image'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $imageName = time() . "_" . uniqid() . "." . $ext;
    $destination = $uploadDir . $imageName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {

        // Delete old image if it's NOT the placeholder
        if ($oldImage !== $placeholder && file_exists($uploadDir . $oldImage)) {
            unlink($uploadDir . $oldImage);
        }

    } else {
        $_SESSION['error'] = "Image upload failed.";
        header("Location: update_vehicle_form.php?id=" . $id);
        exit();
    }
}

// Update DB
$query = "
    UPDATE vehicles
    SET Make = :make,
        Model = :model,
        Year = :year,
        Mileage = :mileage,
        vehicle_image = :image
    WHERE id = :id
";

$statement = $db->prepare($query);
$statement->bindValue(':make', $make);
$statement->bindValue(':model', $model);
$statement->bindValue(':year', $year);
$statement->bindValue(':mileage', $mileage);
$statement->bindValue(':image', $imageName);
$statement->bindValue(':id', $id);
$statement->execute();
$statement->closeCursor();

$_SESSION['edit_success'] = "Vehicle updated successfully!";
header("Location: index.php");
exit();
