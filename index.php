<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("database.php");  

$queryVehicles = '
    SELECT Make, Model, Year, Mileage 
    FROM vehicles 
    ORDER BY Year DESC';   

$statement = $db->prepare($queryVehicles);
$statement->execute();
$vehicles = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Inventory - Home</title>
    <link rel="stylesheet" type="text/css" href="css/vehicle.css" />
</head>

<body>
    <?php include("header.php"); ?>

    <main>
        <h2>Vehicle Inventory List</h2>

        <?php if (empty($vehicles)): ?>
            <p>No vehicles found in the database yet.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Mileage</th>
                </tr>

                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?= htmlspecialchars($vehicle['Make'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($vehicle['Model'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($vehicle['Year'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($vehicle['Mileage'] ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </main>

    <?php include("footer.php"); ?> 
</body>
</html>