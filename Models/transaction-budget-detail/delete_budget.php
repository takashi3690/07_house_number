<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/DB.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $budget_id = filter_input(INPUT_POST, 'budget_id', FILTER_VALIDATE_INT);

    $db = new DB();
    $pdo = $db->getPDO();

    // 予算データを削除
    $stmt = $pdo->prepare('DELETE FROM budgets WHERE id = :id');
    $stmt->bindValue(':id', $budget_id, PDO::PARAM_INT);
    $stmt->execute();

    // 削除後は一覧ページにリダイレクト
    header('Location: /practice/07_house_number/view/transactions-detail/budget_detail.php');
    exit;
}
