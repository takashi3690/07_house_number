<?php
declare(strict_types=1);
require_once(dirname(__FILE__) . '/DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user']['id'];
$date = $_GET['date'] ?? '';
$category = $_GET['category'] ?? '';
try {
    $db = new DB();
    $pdo = $db->getPDO();
    $sql = '
    SELECT t.id, t.amount, t.memo, t.date, t.payment_type, c.name AS category_name
    FROM transactions t
    JOIN categories c ON t.category_id = c.id
    WHERE t.user_id = ? AND DATE(t.date) = ?
';
$params = [$user_id, $date];
$year = (int)($_GET['year'] ?? date('Y'));
$month = (int)($_GET['month'] ?? date('m'));
$month_str = sprintf('%04d-%02d-01', $year, $month);


if ($category) {
    $sql .= ' AND c.name = ?';
    $params[] = $category;
}

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = array_sum(array_column($transactions, 'amount'));
    }

catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}
