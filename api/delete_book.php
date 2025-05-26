<?php
// api/delete_book.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['id'])) {
    http_response_code(400);
    exit(json_encode(['error'=>'ID faltando']));
}

$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
$stmt->execute([$data['id']]);

echo json_encode(['success' => true]);
