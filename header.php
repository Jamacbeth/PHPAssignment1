<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <h1>Vehicle Inventory System</h1>

    <nav>
        <ul>
            <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === TRUE): ?>

                <li>Welcome, <?php echo htmlspecialchars($_SESSION['userName']); ?></li>
                <li><a href="logout.php">Logout</a></li>

            <?php else: ?>

                <li><a href="login_form.php">Login</a></li>
                <li><a href="register_user_form.php">Register</a></li>

            <?php endif; ?>
        </ul>
    </nav>
</header>
