<?php
$host = "localhost";    // Database host
$user = "root";         // Database username
$pass = "";             // Database password
$dbname = "mor_system"; // Database name

// Create PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// For backward compatibility with existing code
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("MySQLi Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>

