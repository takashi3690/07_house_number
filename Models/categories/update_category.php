<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . '/DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}
$user_id = $_SESSION['user']['id'];
$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');


try {
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare('UPDATE categories SET name = :name WHERE id = :id AND user_id = :user_id');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: /practice/07_house_number/view/categories/category_list.php');
    exit;
    
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}
