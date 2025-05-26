<?php
$host   = 'localhost';
$dbname = 'library';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    alert('Erro de conexão: ' . $e->getMessage());
    exit('Erro de conexão: ' . $e->getMessage());
}
