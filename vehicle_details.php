<link rel="stylesheet" type="text/css" href="css/global.css">

<?php
session_start();
require_once 'database.php';

// Get vehicle ID
$vehicle_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$vehicle_id) {
    $_SESSION['error'] = "Invalid vehicle ID.";
    header("Location: index.php");
    exit();
}

// Fetch vehicle
$query = "SELECT * FROM vehicles WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindValue(':id', $vehicle_id);
$statement->execute();
$vehicle = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

if (!$vehicle) {
    $_SESSION['error'] = "Vehicle not found.";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($vehicle['Make']) ?> Details</title>
    <link rel="stylesheet" href="css/vehicle.css">
    <style>
        .vehicle-full {
            width: 400px;
            height: 400px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .details-box {
            max-width: 500px;
            padding: 20px;
            background: #f7f7f7;
            border-radius: 8px;
        }
        .details-box p {
            font-size: 18px;
            margin: 8px 0;
        }
    </style>
</head>
<body>

<?php include("header.php"); ?>

<main>
    <h2>Vehicle Details</h2>

    <!-- Vehicle Image -->
    <?php if (!empty($vehicle['vehicle_image']) && $vehicle['vehicle_image'] !== 'ph.jpg'): ?>
        <img src="uploads/<?= htmlspecialchars($vehicle['vehicle_image']) ?>" class="vehicle-full">
    <?php else: ?>
        <div class="no-image-placeholder" style="width:400px;height:400px;display:flex;align-items:center;justify-content:center;font-size:20px;">
            No Image Available
        </div>
    <?php endif; ?>

    <div class="details-box">
        <p><strong>Make:</strong> <?= htmlspecialchars($vehicle['Make']) ?></p>
        <p><strong>Model:</strong> <?= htmlspecialchars($vehicle['Model']) ?></p>
        <p><strong>Year:</strong> <?= htmlspecialchars($vehicle['Year']) ?></p>
        <p><strong>Mileage:</strong> <?= number_format($vehicle['Mileage']) ?> km</p>
        <p><strong>Dealership:</strong> 
            <?= !empty($vehicle['Dealership']) ? htmlspecialchars($vehicle['Dealership']) : "Not assigned" ?>
        </p>
    </div>

    <br>
    <a href="index.php">Back to Inventory</a>
</main>

<?php include("footer.php"); ?>

</body>
</html>
