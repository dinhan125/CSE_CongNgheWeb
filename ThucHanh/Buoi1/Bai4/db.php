<?php
// db.php
$host = '127.0.0.1';
$db   = 'thuchanh1_db';
$user = 'root'; // User mặc định của XAMPP
$pass = 'dinhan125';     // Pass mặc định thường để trống

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>