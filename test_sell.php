<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "TEST START<br>";

require_once('database.php');
echo "DB OK<br>";

session_start();
echo "Session OK<br>";

echo "UserID: " . ($_SESSION['userID'] ?? 'NOT SET') . "<br>";

$make = $_POST['make'] ?? 'NO MAKE';
echo "Make: $make<br>";

echo "TEST END<br>";
