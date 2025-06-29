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


try {
    $db = new DB();
    $pdo = $db->getPDO();

    // 月間予算一覧（カテゴリ名と金額）
    $stmt = $pdo->prepare("
        SELECT c.name AS category_name, b.amount
        FROM budgets b
        JOIN categories c ON b.category_id = c.id
        WHERE b.user_id = ? AND YEAR(b.month) = ? AND MONTH(b.month) = ?
    ");
    $stmt->execute([$user_id, $year, $month]);
    $budgets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 月間予算合計
    $stmt = $pdo->prepare("
        SELECT SUM(amount) FROM budgets 
        WHERE user_id = ? AND YEAR(month) = ? AND MONTH(month) = ?
    ");
    $stmt->execute([$user_id, $year, $month]);
    $monthlyBudgetTotal = (int)$stmt->fetchColumn();

    // 月間支出合計
    $stmt = $pdo->prepare("
        SELECT SUM(amount) FROM transactions 
        WHERE user_id = ? AND YEAR(date) = ? AND MONTH(date) = ?
    ");
    $stmt->execute([$user_id, $year, $month]);
    $monthlyExpenseTotal = (int)$stmt->fetchColumn();

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
    exit;
}

try {
    $db = new DB();
    $pdo = $db->getPDO();

    // 月間予算合計を取得
    $stmt = $pdo->prepare("SELECT SUM(amount) AS total_budget FROM budgets WHERE user_id = ? AND YEAR(month) = ? AND MONTH(month) = ?");
    $stmt->execute([$user_id, $year, $month]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $monthlyBudgetTotal = (int)($row['total_budget'] ?? 0);

    // 月間支出合計を取得
    $stmt = $pdo->prepare("SELECT SUM(amount) AS total_expense FROM transactions WHERE user_id = ? AND YEAR(date) = ? AND MONTH(date) = ?");
    $stmt->execute([$user_id, $year, $month]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $monthlyExpenseTotal = (int)($row['total_expense'] ?? 0);

    // 差額を計算
    $balance = $monthlyBudgetTotal - $monthlyExpenseTotal;

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
    $monthlyBudgetTotal = 0;
    $monthlyExpenseTotal = 0;
    $balance = 0;
}

?>
