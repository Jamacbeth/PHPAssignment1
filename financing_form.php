<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Apply for Financing</title>
    <link rel="stylesheet" type="text/css" href="css/global.css">

</head>

<body>

<?php include("header.php"); ?>

<main>
    <h2>Apply for Financing</h2>

    <?php
        if (isset($_SESSION['finance_error'])) {
            echo '<p style="color: red; font-weight: bold;">' . 
                 htmlspecialchars($_SESSION['finance_error']) . 
                 '</p>';
            unset($_SESSION['finance_error']);
        }

        if (isset($_SESSION['finance_success'])) {
            echo '<p style="color: green; font-weight: bold;">' . 
                 htmlspecialchars($_SESSION['finance_success']) . 
                 '</p>';
            unset($_SESSION['finance_success']);
        }
    ?>

    <form action="financing_process.php" method="post" id="financing_form">

        <div id="data">

            <label>Full Name:</label>
            <input type="text" name="fullName" required><br>

            <label>Email:</label>
            <input type="email" name="email" required><br>

            <label>Phone:</label>
            <input type="text" name="phone" required><br>

            <label>Annual Income:</label>
            <input type="number" name="income" required><br>

            <label>Employment Status:</label>
            <input type="text" name="employmentStatus" required><br>

            <label>Credit Score:</label>
            <input type="number" name="creditScore" required><br>

            <label>Message (optional):</label>
            <textarea name="message" rows="4" cols="40"></textarea><br>

        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Submit Application"><br>
        </div>

    </form>

    <p><a href="index.php">Back to Home</a></p>

</main>

<?php include("footer.php"); ?>

</body>
</html>
