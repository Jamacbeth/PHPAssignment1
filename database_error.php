<?php
    session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Vehicle Inventory - Database Error</title>
        <link rel="stylesheet" type="text/css" href="css/vehicle.css" />
    </head>

    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Database Error</h2>

            <p>There was an error connecting to the database.</p>
            <p>The database must be installed.</p>
            <p>MySQL must be running.</p>
            <p>Error Message: <?php echo $_SESSION["database_error"]; ?>

            <p><a href="index.php">View Vehicle inventory system</a></p>
        </main>

        <?php include("footer.php"); ?> 

    </body>
</html>

