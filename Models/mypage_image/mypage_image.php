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
$image = null;
if (isset($_SESSION['user']['id'])) {
    try {
        $db = new DB();
        $pdo = $db->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user_images WHERE user_id = ? ORDER BY uploaded_at DESC LIMIT 1");
        $stmt->execute([$_SESSION['user']['id']]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $image = null;
    }
}
