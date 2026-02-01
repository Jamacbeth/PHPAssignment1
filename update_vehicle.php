<?php
session_start();
require_once('database.php');

$orig_make = filter_input(INPUT_GET, 'make');
$orig_model = filter_input(INPUT_GET, 'model');
$orig_year = filter_input(INPUT_GET, 'year', FILTER_VALIDATE_INT);
$orig_mileage = filter_input(INPUT_GET, 'mileage', FILTER_VALIDATE_INT);

if ($orig_make == null || $orig_model == null || $orig_year == null || $orig_mileage == null) {
    $_SESSION["edit_error"] = "Invalid vehicle reference.";
    header("Location: index.php");
    exit;
}

$query = 'SELECT Make, Model, Year, Mileage FROM vehicles WHERE Make = :make AND Model = :model AND Year = :year AND Mileage = :mileage';
$statement = $db->prepare($query);
$statement->execute([
    ':make' => $orig_make,
    ':model' => $orig_model,
    ':year' => $orig_year,
    ':mileage' => $orig_mileage
]);
$vehicle = $statement->fetch();
$statement->closeCursor();

if (!$vehicle) {
    $_SESSION["edit_error"] = "Vehicle not found.";
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = filter_input(INPUT_POST, 'make');
    $model = filter_input(INPUT_POST, 'model');
    $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
    $mileage = filter_input(INPUT_POST, 'mileage', FILTER_VALIDATE_INT);

    if ($make == null || $model == null || $year == null || $mileage == null) {
        $_SESSION["edit_error"] = "Invalid vehicle data.";
        header("Location: index.php");
        exit;
    }

    $query = 'UPDATE vehicles SET Make = :make, Model = :model, Year = :year, Mileage = :mileage WHERE Make = :orig_make AND Model = :orig_model AND Year = :orig_year AND Mileage = :orig_mileage';
    $statement = $db->prepare($query);
    $statement->execute([
        ':make' => $make,
        ':model' => $model,
        ':year' => $year,
        ':mileage' => $mileage,
        ':orig_make' => $orig_make,
        ':orig_model' => $orig_model,
        ':orig_year' => $orig_year,
        ':orig_mileage' => $orig_mileage
    ]);
    $statement->closeCursor();

    $_SESSION["edit_success"] = "Vehicle updated successfully.";
    header("Location: update_vehicle_confirmation.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Vehicle</title>
    <link rel="stylesheet" type="text/css" href="css/vehicle.css" />
</head>

<body>

<?php include("header.php"); ?>

<main>
    <h2>Edit Vehicle</h2>

    <?php if (!empty($_SESSION['edit_error'])): ?>
        <p style="color:red;"><?= $_SESSION['edit_error'] ?></p>
        <?php unset($_SESSION['edit_error']); ?>
    <?php endif; ?>

    <form action="update_vehicle.php?make=<?= urlencode($orig_make) ?>&model=<?= urlencode($orig_model) ?>&year=<?= $orig_year ?>&mileage=<?= $orig_mileage ?>" method="post">

        <label>Make:</label>
        <input type="text" name="make" value="<?= htmlspecialchars($vehicle['Make']) ?>"><br>

        <label>Model:</label>
        <input type="text" name="model" value="<?= htmlspecialchars($vehicle['Model']) ?>"><br>

        <label>Year:</label>
        <input type="number" name="year" value="<?= htmlspecialchars($vehicle['Year']) ?>"><br>

        <label>Mileage:</label>
        <input type="number" name="mileage" value="<?= htmlspecialchars($vehicle['Mileage']) ?>"><br>

        <input type="submit" value="Update Vehicle">
    </form>

    <p><a href="index.php">Back to Vehicle List</a></p>
</main>

<?php include("footer.php"); ?>

</body>
</html>
