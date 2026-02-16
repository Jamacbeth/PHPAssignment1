<?php
    session_start();   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Car Manager - Registration Confirmation</title>
    <link rel="stylesheet" type="text/css" href="css/contact.css" />
</head>

<body>
    <?php include("header.php"); ?>

    <main>
        <h2>Registration Confirmation</h2>

        <p>
            Thank you, <?php echo htmlspecialchars($_SESSION["userName"]); ?>, for registering.
        </p>

        <p>
            You are now logged in and may proceed to the vehicle list by clicking below.
        </p>

        <p><a href="index.php">View Vehicles</a></p>
    </main>

    <?php include("footer.php"); ?>
</body>

</html>
