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
$name = $_POST['name'] ?? '';

if (trim($name) === '') {
    exit('カテゴリ名が空です。フォームからPOSTされていません。');
}

$db = new DB();
$pdo = $db->getPDO();

try {
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare("INSERT INTO categories (user_id, name, created_at) VALUES (:user_id, :name, NOW())");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();


    header('Location: /practice/07_house_number/view/categories/category_list.php');
    exit;


} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}
