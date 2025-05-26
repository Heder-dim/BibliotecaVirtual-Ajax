<?php
// api/register.php
header('Content-Type: application/json');
require_once dirname(__DIR__) . '/config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$email    = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
$password = $data['password'] ?? '';

if (!$email || strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(['error' => 'E-mail inválido ou senha menor que 6 caracteres']);
    exit;
}

// verifica se já existe
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['error' => 'E-mail já cadastrado']);
    exit;
}

// insere usuário com hash de senha
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hash]);

echo json_encode(['success' => true]);
