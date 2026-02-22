<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Car Manager - Register</title>
   <link rel="stylesheet" type="text/css" href="css/global.css">

</head>

<body>
    <?php include("header.php"); ?>

    <main>
        <h2>Register New User</h2>

        <?php
            if (isset($_SESSION['register_error'])) {
                echo '<p style="color: red; font-weight: bold;">' . 
                     htmlspecialchars($_SESSION['register_error']) . 
                     '</p>';
                unset($_SESSION['register_error']);
            }

            if (isset($_SESSION['register_success'])) {
                echo '<p style="color: green; font-weight: bold;">' . 
                     htmlspecialchars($_SESSION['register_success']) . 
                     '</p>';
                unset($_SESSION['register_success']);
            }
        ?>

        <form action="register_user.php" method="post" id="register_form">

            <div id="data">

                <label>Username:</label>
                <input type="text" name="userName" required /><br />

                <label>Email Address:</label>
                <input type="email" name="emailAddress" required /><br />

                <label>Password:</label>
                <input type="password" name="password" required /><br />

                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required /><br />

            </div>

            <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Register" /><br />
            </div>

        </form>

        <p><a href="login_form.php">Back to Login</a></p>

    </main>

    <?php include("footer.php"); ?>

</body>
</html>
