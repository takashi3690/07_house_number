<?php

declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(dirname(__FILE__) . '/DB.php');
require_once(dirname(__FILE__) . '../categories/category.php');

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'];
    $amount = $_POST['amount'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $month = $_POST['month'] ?? '';
    if ($month !== '') {
        $month .= '-01';
    }

    try {
        $db = new DB();
        $pdo = $db->getPDO();

        // カテゴリIDの検証
        $stmt = $pdo->prepare("SELECT id FROM categories WHERE id = ? AND user_id = ?");
        $stmt->execute([$category_id, $user_id]);
        if (!$stmt->fetch()) {
            exit('無効なカテゴリIDです');
        }

        // INSERT または UPDATE
        $stmt = $pdo->prepare("SELECT id FROM budgets WHERE user_id = ? AND category_id = ? AND month = ?");
        $stmt->execute([$user_id, $category_id, $month]);
        $existing = $stmt->fetch();

        if ($existing) {
            $stmt = $pdo->prepare("UPDATE budgets SET amount = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$amount, $existing['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO budgets (user_id, category_id, month, amount, created_at, updated_at)
                                   VALUES (?, ?, ?, ?, NOW(), NOW())");
            $stmt->execute([$user_id, $category_id, $month, $amount]);
        }

        header("Location: /practice/07_house_number/view/carendar/carendar.php");
        exit;
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}
