<?php
    session_start();   
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Vehicle Manager - Add Vehicle Confirmation</title>
        <link rel="stylesheet" type="text/css" href="css/vehicle.css" />
    </head>

    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Add Vehicle Confirmation</h2>
            <p>
                Thank you for adding a new vehicle to the inventory.
                The vehicle information has been saved successfully.
            </p>                        

            <p><a href="index.php">Back to Home</a></p>

        </main>

        <?php include("footer.php"); ?> 

    </body>
</html>
