<?php
session_start();
require_once('database.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}


$query = "SELECT s.*, r.userName 
          FROM user_submissions s
          JOIN registrations r ON s.userID = r.userID
          ORDER BY submitted_at DESC";

$statement = $db->prepare($query);
$statement->execute();
$submissions = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Vehicle Submissions</title>
   <link rel="stylesheet" type="text/css" href="css/global.css">

</head>

<body>

<?php include("header.php"); ?>

<main>
    <h2>User Vehicle Submissions</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>User</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Mileage</th>
            <th>Price</th>
            <th>Description</th>
            <th>Status</th>
        </tr>

        <?php foreach ($submissions as $s): ?>
        <tr>
            <td><?php echo htmlspecialchars($s['userName']); ?></td>
            <td><?php echo htmlspecialchars($s['make']); ?></td>
            <td><?php echo htmlspecialchars($s['model']); ?></td>
            <td><?php echo htmlspecialchars($s['year']); ?></td>
            <td><?php echo htmlspecialchars($s['mileage']); ?></td>
            <td><?php echo htmlspecialchars($s['price']); ?></td>
            <td><?php echo htmlspecialchars($s['description']); ?></td>
            <td><?php echo htmlspecialchars($s['status']); ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

</main>

<?php include("footer.php"); ?>

</body>
</html>
