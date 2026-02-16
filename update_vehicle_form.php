<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== TRUE) {
    header("Location: login_form.php");
    exit;
}

require_once 'database.php';

$vehicle_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$vehicle_id) {
    $_SESSION['error'] = "Invalid vehicle ID.";
    header("Location: index.php");
    exit;
}

// Fetch vehicle
$query = "SELECT * FROM vehicles WHERE id = :id";
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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Vehicle</title>
    <link rel="stylesheet" href="css/vehicle.css">
</head>
<body>

<?php include("header.php"); ?>

<main>
    <h2>Edit Vehicle</h2>

    <form action="update_vehicle.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
        <input type="hidden" name="old_image" value="<?= htmlspecialchars($vehicle['vehicle_image']) ?>">

        <label>Make:</label>
        <input type="text" name="make" value="<?= htmlspecialchars($vehicle['Make']) ?>" required><br>

        <label>Model:</label>
        <input type="text" name="model" value="<?= htmlspecialchars($vehicle['Model']) ?>" required><br>

        <label>Year:</label>
        <input type="number" name="year" value="<?= htmlspecialchars($vehicle['Year']) ?>" required><br>

        <label>Mileage:</label>
        <input type="number" name="mileage" value="<?= htmlspecialchars($vehicle['Mileage']) ?>" required><br>

        <label>Current Image:</label><br>

        <?php if (!empty($vehicle['vehicle_image']) && $vehicle['vehicle_image'] !== 'ph.jpg'): ?>
            <img src="uploads/<?= htmlspecialchars($vehicle['vehicle_image']) ?>" class="vehicle-thumbnail">
        <?php else: ?>
            <div class="no-image-placeholder">No image</div>
        <?php endif; ?>

        <br><br>

        <label>Replace Image:</label>
        <input type="file" name="vehicle_image" accept="image/*"><br><br>

        <input type="submit" value="Update Vehicle">

    </form>

    <p><a href="index.php">Back to List</a></p>
</main>

<?php include("footer.php"); ?>

</body>
</html>
