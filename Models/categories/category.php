<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . '/DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: /login.php'); // 未ログインはリダイレクト
    exit;
}

$user_id = $_SESSION['user']['id'];

try {
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}
