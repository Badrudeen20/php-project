<?php

// Database credentials
$host = 'localhost'; // e.g., 'localhost' or '127.0.0.1'
$dbname = 'students';
$username = 'root';
$password = '';
// PDO connection string
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Create a PDO instance
try {
    $conn = new PDO($dsn, $username, $password, $options);
    echo "Connected successfully to the database";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>