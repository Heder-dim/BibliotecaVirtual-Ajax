<?php
// api/update_book.php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
if (empty($data['id'])) {
    http_response_code(400);
    exit(json_encode(['error'=>'ID faltando']));
}

$sql = "UPDATE books
        SET title = :title, author = :author, year = :year, isbn = :isbn
        WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':title'  => $data['title'],
    ':author' => $data['author'],
    ':year'   => $data['year'],
    ':isbn'   => $data['isbn'] ?? null,
    ':id'     => $data['id']
]);

echo json_encode(['success' => true]);
