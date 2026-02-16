<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== TRUE) {
    header("Location: login_form.php");
    exit;
}

require_once 'database.php';

$vehicle_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$vehicle_id) {
    $_SESSION['error'] = "Invalid vehicle ID.";
    header("Location: index.php");
    exit;
}

// Fetch current vehicle to get image name
$query = "SELECT vehicle_image FROM vehicles WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $vehicle_id);
$statement->execute();
$vehicle = $statement->fetch();
$statement->closeCursor();

if (!$vehicle) {
    $_SESSION['error'] = "Vehicle not found.";
    header("Location: index.php");
    exit;
}

$old_image = $vehicle['vehicle_image'];
$upload_dir = "uploads/";
$placeholder = "ph.jpg";

// Delete image if not placeholder
if ($old_image !== $placeholder && file_exists($upload_dir . $old_image)) {
    unlink($upload_dir . $old_image);
}

// Delete vehicle from database
$query = "DELETE FROM vehicles WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $vehicle_id);
$statement->execute();
$statement->closeCursor();

$_SESSION['edit_success'] = "Vehicle deleted successfully.";
header("Location: index.php");
exit;
?>
