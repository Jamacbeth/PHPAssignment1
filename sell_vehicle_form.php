<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sell Your Vehicle</title>
<link rel="stylesheet" type="text/css" href="css/global.css">

</head>

<body>

<?php include("header.php"); ?>

<main>
    <h2>Sell Your Vehicle</h2>

    <?php
        if (isset($_SESSION['sell_error'])) {
            echo '<p style="color: red; font-weight: bold;">' . 
                 htmlspecialchars($_SESSION['sell_error']) . 
                 '</p>';
            unset($_SESSION['sell_error']);
        }

        if (isset($_SESSION['sell_success'])) {
            echo '<p style="color: green; font-weight: bold;">' . 
                 htmlspecialchars($_SESSION['sell_success']) . 
                 '</p>';
            unset($_SESSION['sell_success']);
        }
    ?>


    
    <form action="sell_vehicle.php" method="post" id="sell_vehicle_form">

        <div id="data">

            <label>Make:</label>
            <input type="text" name="make" required><br>

            <label>Model:</label>
            <input type="text" name="model" required><br>

            <label>Year:</label>
            <input type="number" name="year" min="1900" max="2100" required><br>

            <label>Mileage:</label>
            <input type="number" name="mileage" required><br>

            <label>Price:</label>
            <input type="number" name="price" required><br>

            <label>Description:</label>
            <textarea name="description" rows="4" cols="40" required></textarea><br>

        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Submit Vehicle"><br>
        </div>

    </form>

    <!-- Back button -->
    <p><a href="index.php">Back to Home</a></p>

</main>

<?php include("footer.php"); ?>

</body>
</html>
