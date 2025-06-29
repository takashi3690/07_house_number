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


$user_id = $_SESSION['user']['id'];
$category_id = $_POST['category_id'] ?? null;
$amount = $_POST['amount'] ?? null;
$payment_type = $_POST['payment_type'] ?? null;
$date = $_POST['date'] ?? null;
$memo = $_POST['memo'] ?? '';



if ($category_id === null || $amount === null || $payment_type === null || $date === null) {
    exit('必須項目が未入力です');
}

try {
    $db = new DB();
    $pdo = $db->getPDO();

    $stmt = $pdo->prepare("INSERT INTO transactions
        (user_id, category_id, amount, payment_type, memo, date, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");

    $stmt->execute([$user_id, $category_id, $amount, $payment_type, $memo, $date]);

    header('Location:  /practice/07_house_number/view/carendar/carendar.php');
    exit;

} catch (PDOException $e) {
    exit('登録に失敗しました: ' . $e->getMessage());
}

try {
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare("
    SELECT DAY(date) AS day, SUM(amount) AS total
    FROM transactions
    WHERE user_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?
    GROUP BY DAY(date)"
    );
    $stmt->execute([$user_id, sprintf('%04d-%02d', $year, $month)]);
    $dailyExpenses = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dailyExpenses[(int)$row['day']] = (int)$row['total'];
    }
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}


