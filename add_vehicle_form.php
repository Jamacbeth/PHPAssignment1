<?php
session_start();
require_once 'database.php';
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
        <p style="color:red;">
            <?= $_SESSION['add_error']; ?>
        </p>
        <?php unset($_SESSION['add_error']); ?>
    <?php endif; ?>

    <form action="add_vehicle.php" method="post" id="add_vehicle_form">

        <div id="data">

            <label>Make:</label>
            <input type="text" name="make" required><br>

            <label>Model:</label>
            <input type="text" name="model" required><br>

            <label>Year:</label>
            <input type="number" name="year" required><br>

            <label>Mileage:</label>
            <input type="number" name="mileage" required><br>

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
