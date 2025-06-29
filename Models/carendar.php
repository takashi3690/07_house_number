<?php

declare(strict_types=1);
require_once(dirname(__FILE__) . '/DB.php');

//カレンダー
date_default_timezone_set('Asia/Tokyo');

$year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');

$firstDayOfMonth = new DateTime("$year-$month-01");
$daysInMonth = (int)$firstDayOfMonth->format('t');
$startWeekday = (int)$firstDayOfMonth->format('w');

$prevMonth = new DateTime("$year-$month-01");
$prevMonth->modify('-1 month');
$nextMonth = new DateTime("$year-$month-01");
$nextMonth->modify('+1 month');

$weekLabels = ['日', '月', '火', '水', '木', '金', '土'];

$carendar = [];
$day = 1;
$weekday = 0;

for ($i = 0; $i < 6; $i++) { //6行作成
    $row = [];
    for ($j = 0; $j < 7; $j++) {
        if ($i === 0 && $j < $startWeekday) {
            $row[] = ''; //最初の空欄
    } elseif ($day <= $daysInMonth) {
        $row[] = $day;
        $day++;
    } else {
        $row[] = '';
    }
    }
    $carendar[] = $row;
}



//navのユーザ名表示

$user_name = '';
$login_id = $_GET['id'] ?? '';

if ($login_id) {

    try {
        $db = new DB();
        $pdo = $db->getPDO();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $login_id, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_name = $user['username'];
    } catch (PDOException $e) {
        echo "エラー: " . $e->getMessage();
    }
}

$user_id = $_SESSION['user']['id'];

$targetMonth = sprintf('%04d-%02d-01', $year, $month);

try {
    $db = new DB();
    $pdo = $db->getPDO();

    $stmt = $pdo->prepare("
        SELECT c.name, b.amount
        FROM budgets b
        JOIN categories c ON b.category_id = c.id 
        WHERE b.user_id = ? AND b.month = ?
    ");
    $stmt->execute([$user_id, $targetMonth]);
    $budgets = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "予算取得エラー: " . $e->getMessage();
    $budgets = [];
}

try {
    $db = new DB();
    $pdo = $db->getPDO();
    $stmt = $pdo->prepare("
        SELECT DAY(date) AS day, SUM(amount) AS total
        FROM transactions
        WHERE user_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?
        GROUP BY DAY(date)
    ");
    $stmt->execute([$user_id, sprintf('%04d-%02d', $year, $month)]);
    $dailyExpenses = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $dailyExpenses[(int)$row['day']] = (int)$row['total'];
    }
} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

///日にちの支出
$dailyCategoryExpenses = [];
try {
    $db = new DB();
    $pdo = $db->getPDO();

    $stmt = $pdo->prepare("
        SELECT DAY(t.date) AS day, c.name AS category, SUM(t.amount) AS total
        FROM transactions t
        JOIN categories c ON t.category_id = c.id
        WHERE t.user_id = ? AND DATE_FORMAT(t.date, '%Y-%m') = ?
        GROUP BY day, c.name
    ");
    $stmt->execute([$user_id, sprintf('%04d-%02d', $year, $month)]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $day = (int)$row['day'];
        $category = $row['category'];
        $total = (int)$row['total'];
        $dailyCategoryExpenses[$day][$category] = $total;
    }
} catch (PDOException $e) {
    echo '支出取得エラー: ' . $e->getMessage();
}
//月の合計金額
try {
    $db = new DB();
    $pdo = $db->getPDO();

    $stmt = $pdo->prepare("
        SELECT SUM(amount) AS total
        FROM transactions
        WHERE user_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?
    ");
    $stmt->execute([$user_id, sprintf('%04d-%02d', $year, $month)]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $monthlyTotal = $row['total'] ?? 0;
} catch (PDOException $e) {
    $monthlyTotal = 0;
}
