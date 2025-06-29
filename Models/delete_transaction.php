<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/DB.php';

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$transaction_id = $_POST['id'] ?? null;

if (!$transaction_id) {
    exit('不正なリクエストです');
}

try {
    $db = new DB();
    $pdo = $db->getPDO();

    $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
    $stmt->execute([$transaction_id, $user_id]);

    $redirectUrl = $_SERVER['HTTP_REFERER'] ?? '/practice/07_house_number/view/carendar/carendar.php';
    header('Location: ' . $redirectUrl);
    exit;

} catch (PDOException $e) {
    exit('削除に失敗しました: ' . $e->getMessage());
}
