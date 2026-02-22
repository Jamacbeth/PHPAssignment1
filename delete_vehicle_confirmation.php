<?php
    session_start();   
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Vehicle Manager - Delete Vehicle Confirmation</title>
      <link rel="stylesheet" type="text/css" href="css/global.css">

    </head>

    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Delete Vehicle Confirmation</h2>
            <p>
                The selected vehicle has been successfully deleted
                from the inventory. Thank you for keeping the
                records up to date.
            </p>                        

            <p><a href="index.php">Back to Home</a></p>

        </main>

        <?php include("footer.php"); ?> 

    </body>
</html>
