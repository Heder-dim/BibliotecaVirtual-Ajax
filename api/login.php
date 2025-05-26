<?php
// api/login.php
header('Content-Type: application/json');
require_once dirname(__DIR__) . '/config/db.php';

session_start();

$data = json_decode(file_get_contents('php://input'), true);
$email    = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $data['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados incompletos']);
    exit;
}

$stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(['error' => 'E-mail ou senha incorretos']);
    exit;
}

// autentica
$_SESSION['user_id'] = $user['id'];
echo json_encode(['success' => true]);
