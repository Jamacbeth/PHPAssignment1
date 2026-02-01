<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("database.php");

$queryVehicles = 'SELECT Make, Model, Year, Mileage FROM vehicles ORDER BY Year DESC';
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

    <?php if (!empty($_SESSION['edit_success'])): ?>
        <p style="color:green;"><?= $_SESSION['edit_success'] ?></p>
        <?php unset($_SESSION['edit_success']); ?>
    <?php endif; ?>

    <?php if (empty($vehicles)): ?>
        <p>No vehicles found in the database yet.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Mileage</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?= htmlspecialchars($vehicle['Make']) ?></td>
                    <td><?= htmlspecialchars($vehicle['Model']) ?></td>
                    <td><?= htmlspecialchars($vehicle['Year']) ?></td>
                    <td><?= htmlspecialchars($vehicle['Mileage']) ?></td>
                    <td>
                        <a href="update_vehicle.php?make=<?= urlencode($vehicle['Make']) ?>&model=<?= urlencode($vehicle['Model']) ?>&year=<?= $vehicle['Year'] ?>&mileage=<?= $vehicle['Mileage'] ?>">Edit</a>
                        |
                        <form action="delete_vehicle.php" method="post" style="display:inline;">
                            <input type="hidden" name="make" value="<?= htmlspecialchars($vehicle['Make']) ?>">
                            <input type="hidden" name="model" value="<?= htmlspecialchars($vehicle['Model']) ?>">
                            <input type="hidden" name="year" value="<?= htmlspecialchars($vehicle['Year']) ?>">
                            <input type="hidden" name="mileage" value="<?= htmlspecialchars($vehicle['Mileage']) ?>">
                            <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this vehicle?');">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p><a href="add_vehicle_form.php">Add New Vehicle</a></p>
</main>

<?php include("footer.php"); ?>
</body>
</html>
