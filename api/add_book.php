<?php
// api/add_book.php
header('Content-Type: application/json');
require_once dirname(__DIR__) . '/config/db.php';
session_start();


// só quem está logado…
if (empty($_SESSION['user_id'])) {
  http_response_code(401);
  exit(json_encode(['error'=>'Não autorizado']));
}

$data = json_decode(file_get_contents('php://input'), true);
$name        = trim($data['name'] ?? '');
$author      = trim($data['author'] ?? '');
$pages       = intval($data['pages'] ?? 0);
$description = trim($data['description'] ?? '');

if (!$name || !$author || $pages <= 0 || !$description) {
  http_response_code(400);
  exit(json_encode(['error'=>'Todos os campos são obrigatórios']));
}

$sql = "INSERT INTO books (user_id, name, author, pages, description)
        VALUES (:user_id, :name, :author, :pages, :description)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  ':user_id'    => $_SESSION['user_id'],
  ':name'       => $name,
  ':author'     => $author,
  ':pages'      => $pages,
  ':description'=> $description,
]);

echo json_encode([
  'success' => true,
  'id'      => $pdo->lastInsertId()
]);