<?php
declare(strict_types=1);
session_start();
require_once(dirname(__DIR__) . '/DB.php');



if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$id = $_GET['id'] ?? null;

if ($id === null) {
    exit('カテゴリIDが指定されていません。');
}

try {
    $db = new DB();
    $pdo = $db->getPDO();
    
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = :id AND user_id = :user_id');
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
        exit('指定されたカテゴリは存在しません。');
    }
} catch (PDOException $e) {
    exit('DBエラー: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>
