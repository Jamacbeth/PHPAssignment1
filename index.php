<?php
session_start();
require_once 'database.php';

$query = '
    SELECT v.id, v.Make, v.Model, v.Year, v.Mileage,
           v.vehicle_image AS image,
           d.name AS dealership_name
    FROM vehicles v
    LEFT JOIN dealerships d ON v.dealership_id = d.id
    ORDER BY v.Year DESC
';

$statement = $db->prepare($query);
$statement->execute();
$vehicles = $statement->fetchAll();
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vehicle Inventory - Home</title>
    <link rel="stylesheet" type="text/css" href="css/vehicle.css">
</head>
<body>

<?php include("header.php"); ?>

<main>
    <h2>Vehicle Inventory</h2>

    <?php if (!empty($_SESSION['edit_success'])): ?>
        <p class="success-message"><?= htmlspecialchars($_SESSION['edit_success']) ?></p>
        <?php unset($_SESSION['edit_success']); ?>
    <?php endif; ?>

    <?php if (empty($vehicles)): ?>
        <p>No vehicles found.</p>
    <?php else: ?>
        <table class="vehicle-table">
            <tr>
                <th>Image</th>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Mileage</th>
                <th>Dealership</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td>
                        <img src="uploads/<?= htmlspecialchars($vehicle['image'] ?: 'ph.jpg') ?>"
                             class="vehicle-thumbnail">
                    </td>

                    <td>
                        <a href="vehicle_details.php?id=<?= $vehicle['id'] ?>">
                            <?= htmlspecialchars($vehicle['Make']) ?>
                        </a>
                    </td>

                    <td><?= htmlspecialchars($vehicle['Model']) ?></td>
                    <td><?= htmlspecialchars($vehicle['Year']) ?></td>

                    <td>
                        <?php
                            $m = (float) str_replace(',', '', $vehicle['Mileage']);
                            echo number_format($m) . " km";
                        ?>
                    </td>

                    <td><?= htmlspecialchars($vehicle['dealership_name'] ?: 'Not assigned') ?></td>

                    <td>
                        <form action="update_vehicle_form.php" method="get">
                            <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                            <input type="submit" value="Edit">
                        </form>
                    </td>

                    <td>
                        <form action="delete_vehicle.php" method="post">
                            <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                            <input type="submit" value="Delete"
                                   onclick="return confirm('Delete this vehicle?');">
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
