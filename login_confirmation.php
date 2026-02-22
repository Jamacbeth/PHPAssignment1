<?php
    session_start();   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Car Manager - Login Confirmation</title>
  <link rel="stylesheet" type="text/css" href="css/global.css">

</head>

<body>
    <?php include("header.php"); ?>

    <main>
        <h2>Login Confirmation</h2>

        <p>
            Welcome back, <?php echo htmlspecialchars($_SESSION["userName"]); ?>.
        </p>

        <p>
            You are now logged in and may proceed to the vehicle list by clicking below.
        </p>

        <p><a href="index.php">View Vehicles</a></p>
    </main>

    <?php include("footer.php"); ?> 

</body>
</html>
