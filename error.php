<?php
session_start();
$error_message = $_SESSION["add_error"] ?? "Unknown error.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>

    <?php include("header.php"); ?>

    <main>
        <h2>Error Message</h2>

        <p><?= htmlspecialchars($error_message) ?></p>

        <p><a href="add_vehicle_form.php">Go back to Add Vehicle</a></p>
        <p><a href="index.php">Go back to Vehicle List</a></p>
    </main>

    <?php include("footer.php"); ?>

</body>
</html>
