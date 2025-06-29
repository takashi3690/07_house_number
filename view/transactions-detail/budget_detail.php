<?php
session_start();
require_once __DIR__ . '../../../Models/transaction-budget-detail/budget_detail.php';
require_once __DIR__ . '../../../Models/hsc.php';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../../css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title><?= h($year) ?>年<?= h($month) ?>月の予算一覧</title>
    </head>
    <body class="my-container">
        <div class="container">
            <header>
                <h1><?= h($year) ?>年<?= h($month) ?>月の予算一覧</h1>
            </header>
            <div class="main-content">
                <aside class="sidebar">
                    <ul>
                        <li><a href="../carendar/carendar.php">Home</a></li>
                        <li><a href="../../Models/logout.php">ログアウト</a></li>
                        <li><a href="../mypage/mypage.php">マイページ</a></li>
                        <li><a href="../categories/category_list.php">カテゴリ管理</a></li>
                        <li><a href="../carendar/budget.php">予算設定</a></li>
                        <li><a href="../transactions.php">支出登録</a></li>
                    </ul>
                </aside>
                <div class="container-carendar mt-5">
                    <section>
                        <table class="table table-bordered budget-table">
                            <thead class="table-light">
                                <tr>
                                    <th>カテゴリ</th>
                                    <th>予算金額</th>
                                </tr>
                            </thead>
                            <tbody><?php foreach ($budgets as $budget): ?> <tr>
                                    <td><?= h($budget['name']) ?></td>
                                    <td>¥<?= number_format((float)$budget['amount']) ?></td>
                                    <td>
                                        <form action="../../Models/transaction-budget-detail/delete_budget.php" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                            <input type="hidden" name="budget_id" value="<?= h($budget['id']) ?>">
                                            <button type="submit" class="btn-danger">削除</button>
                                        </form>
                                    </td>
                                </tr> <?php endforeach; ?> </tbody>
                        </table>
                        <div class="text-end mt-4">
                            <h2 class="detail_h2"> 合計予算: <a href="../transactions-detail/budget_detail.php?year=<?= $year ?>&month=<?= $month ?>" style="text-decoration:none; color:inherit;"> ￥<?= number_format($monthlyBudgetTotal) ?> 円 </a>
                            </h2>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <footer>
            <p>&copy; 2025 MyWebsite</p>
        </footer>
    </body>
</html>
