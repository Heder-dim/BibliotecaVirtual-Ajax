<?php
// api/list_books.php
header('Content-Type: application/json');
require_once dirname(__DIR__) . '/config/db.php';
session_start();

if (empty($_SESSION['user_id'])) {
  http_response_code(401);
  exit(json_encode(['error'=>'Não autorizado']));
}

// parâmetros
$page     = max(1, intval($_GET['page']     ?? 1));
$pageSize = max(1, intval($_GET['pageSize'] ?? 8));
$name     = trim($_GET['name']     ?? '');
$author   = trim($_GET['author']   ?? '');
$maxPages = intval($_GET['maxPages'] ?? 0);

$offset = ($page - 1) * $pageSize;

// monta WHERE dinamicamente
$where  = 'WHERE 1';
$params = [];

if ($name) {
  $where    .= ' AND b.name LIKE ?';
  $params[]  = "%{$name}%";
}
if ($author) {
  $where    .= ' AND b.author LIKE ?';
  $params[]  = "%{$author}%";
}
if ($maxPages) {
  $where    .= ' AND b.pages <= ?';
  $params[]  = $maxPages;
}

// 1) conta total
$countSql = "SELECT COUNT(*) FROM books b $where";
$stmt = $pdo->prepare($countSql);
$stmt->execute($params);
$total = (int) $stmt->fetchColumn();

// 2) busca a página (LIMIT inline)
$listSql = "
  SELECT
    b.name,
    b.author,
    b.description,
    b.pages,
    u.email AS added_by
  FROM books b
  LEFT JOIN users u ON u.id = b.user_id
  $where
  ORDER BY b.id DESC
  LIMIT $offset, $pageSize
";
$stmt = $pdo->prepare($listSql);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// devolve JSON
echo json_encode([
  'books' => $books,
  'total' => $total
]);