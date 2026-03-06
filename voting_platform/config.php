<?php
// Database configuration - update with your credentials
// use hostname or IP; if MySQL listens on a non‑standard port include it after a colon
// examples: 'localhost', '127.0.0.1', or '127.0.0.1:3360'
$host = 'localhost:3360';
$db   = 'voting_platform';   // <-- set this to the name of your database
$user = 'your_user';          // e.g. 'root' for default XAMPP install
$pass = 'your_password';      // leave blank if root has no password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Alternative connection method
$pdo = new PDO('mysql:host=localhost;dbname=voting_platform;charset=utf8', 'root', '');
