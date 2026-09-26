<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'demo_sqli';

// Create connection without error reporting display for realistic look
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    // Fallback or silent fail to keep website looking real
    die("Database Connection Error.");
}

mysqli_set_charset($conn, "utf8");
?>
