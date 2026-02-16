<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== TRUE) {
    header("Location: login_form.php");
    exit;
}

require_once 'database.php';

// Fetch all dealerships for the dropdown
try {
    $stmt = $db->prepare("SELECT id, name, city FROM dealerships ORDER BY name");
    $stmt->execute();
    $dealerships = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $dealerships = [];
    error_log("Error fetching dealerships: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Vehicle</title>
    <link rel="stylesheet" type="text/css" href="css/vehicle.css">
</head>

<body>

<?php include("header.php"); ?>

<main>
    <h2>Add Vehicle</h2>

    <?php if (!empty($_SESSION['add_error'])): ?>
        <p class="error-message">
            <?= htmlspecialchars($_SESSION['add_error']); ?>
        </p>
        <?php unset($_SESSION['add_error']); ?>
    <?php endif; ?>

    <form action="add_vehicle.php" method="post" id="add_vehicle_form" enctype="multipart/form-data">

        <div id="data">

            <label>Make:</label>
            <input type="text" name="make" required><br>

            <label>Model:</label>
            <input type="text" name="model" required><br>

            <label>Year:</label>
            <input type="number" name="year" required><br>

            <label>Mileage:</label>
            <input type="number" name="mileage" required><br>

            <label>Dealership:</label>
            <select name="dealership_id" required>
                <option value="">-- Select Dealership --</option>
                <?php foreach ($dealerships as $dealership): ?>
                    <option value="<?= $dealership['id'] ?>">
                        <?= htmlspecialchars($dealership['name']) ?> (<?= htmlspecialchars($dealership['city']) ?>)
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Vehicle Image:</label>
            <input type="file" name="vehicle_image" accept="image/*"><br>

        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Add Vehicle"><br>
        </div>

    </form>

    <p><a href="index.php">Back to Vehicle List</a></p>

</main>

<?php include("footer.php"); ?>

</body>
</html>
