<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . '/DB.php');
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];
$id = $_POST['id'] ?? null;

if ($id === null) {
    exit('IDが指定されていません。');
}

try {
    $db = new DB();
    $pdo = $db->getPDO();

    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id AND user_id = :user_id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: /practice/07_house_number/view/categories/category_list.php');

    exit;

} catch (PDOException $e) {
    exit('エラーが発生しました: ' . $e->getMessage());
}
