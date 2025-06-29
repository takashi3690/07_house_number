<?php
session_start();
require_once __DIR__ . '../../../Models/carendar.php';
require_once __DIR__ . '../../../Models/trnsactions_budget.php';
require_once __DIR__ . '../../../Models/hsc.php';

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <title>家計簿</title>
    </head>
    <body>
        <header>
            <h1>家計簿</h1>
        </header>
        <div class="container">
            <div class="main-content">
                <aside class="sidebar">
                    <ul>
                        <li><a class="current" href="javascript:void(0);">Home</a></li>
                        <li><a href="../../Models/logout.php">ログアウト</a></li>
                        <li><a href="../mypage/mypage.php">マイページ</a></li>
                        <li><a href="../categories/category_list.php">カテゴリ管理</a></li>
                        <li><a href="budget.php">予算設定</a></li>
                        <li><a href="transactions.php">支出登録</a></li>
                    </ul>
                </aside>
                <div class="container-carendar mt-5">
                    <h3><?= h($year) ?>年<?= h($month) ?>月の予算合計</h3>
                    <p class="budget-total"> 合計予算: <a href="../transactions-detail/budget_detail.php?year=<?= $year ?>&month=<?= $month ?>" style="text-decoration:none; color:inherit;"> ￥<?= number_format($monthlyBudgetTotal) ?> 円 </a>
                    </p>
                    <h3><?= h($year) ?>年<?= h($month) ?>月の支出</h3>
                    <p class="expense-total"> 合計支出: ￥<?= number_format($monthlyExpenseTotal) ?> 円 </p>
                    <h3><?= h($year) ?>年<?= h($month) ?>予算残高</h3>
                    <p> 予算残高: <span class="<?= $balance < 0 ? 'text-danger' : 'text-success' ?>"> ￥<?= number_format($balance) ?> 円 </span>
                    </p>
                    <h3 class="mb-4">
                        <a href="?year=<?php echo $prevMonth->format('Y'); ?>&month=<?php echo $prevMonth->format('m'); ?>">&lt;</a>
                        <span class="mx-3"><?php echo $year; ?>年 <?php echo $month; ?>月</span>
                        <a href="?year=<?php echo $nextMonth->format('Y'); ?>&month=<?php echo $nextMonth->format('m'); ?>">&gt;</a>
                    </h3>
                    <table class="table table-bordered">
                        <tr> <?php foreach ($weekLabels as $label): ?> <th><?php echo $label; ?></th> <?php endforeach; ?> </tr> <?php foreach ($carendar as $week): ?> <tr> <?php foreach ($week as $i => $day): ?> <?php
                    $class = '';
                    if ($day === '') {
                        $class = '';
                    } elseif ($i == 0) {
                        $class = 'sunday';
                    } elseif ($i == 6) {
                        $class = 'saturday';
                    }
                    // 今日の日付にクラス追加
                    if ($day !== '' && $day == date('j') && $month == date('n') && $year == date('Y')) {
                        $class .= ($class ? ' ' : '') . 'today';
                    }
                ?> <td class="<?php echo trim($class); ?>"> <?php echo $day; ?> <?php if ($day !== '' && isset($dailyCategoryExpenses[$day])): ?> <ul class="expense-list" style="list-style: none; padding-left: 0;"> <?php foreach ($dailyCategoryExpenses[$day] as $category => $amount): ?> <li>
                                        <span class="category-name">
                                            <a href="detail.php?date=<?= $year ?>-<?= sprintf('%02d', $month) ?>-<?= sprintf('%02d', $day) ?>&category=<?= urlencode($category) ?>" class="expense-amount text-danger small"> ￥<?= number_format($amount) ?> </a>
                                        </span>
                                    </li> <?php endforeach; ?> </ul> <?php endif; ?> </td> <?php endforeach; ?> </tr> <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <!-- フッター -->
        <footer>
            <p>&copy; 2025 MyWebsite</p>
        </footer>
    </body>
</html>
