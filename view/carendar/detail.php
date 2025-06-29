<?php
session_start();
require_once __DIR__ . '../../../Models/detail.php';
require_once __DIR__ . '../../../Models/carendar.php';
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
    <body class="my-container">
        <div class="container">
            <!-- ヘッダー -->
            <header>
                <h1>支出の詳細</h1>
            </header>
            <!-- サイドバー + メインコンテンツ -->
            <div class="main-content">
                <!-- サイドバー -->
                <aside class="sidebar">
                    <ul>
                        <li><a href="../carendar/carendar.php">Home</a></li>
                        <li><a href="../../Models/logout.php">ログアウト</a></li>
                        <li><a href="../mypage/mypage.php">マイページ</a></li>
                        <li><a href="../categories/category_list.php">カテゴリ管理</a></li>
                        <li><a href="budget.php">予算設定</a></li>
                        <li><a href="transactions.php">支出登録</a></li>
                    </ul>
                </aside>
                <div>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>カテゴリ</th>
                                <th>金額</th>
                                <th>支払方法</th>
                                <th>メモ</th>
                                <th>登録日時</th>
                            </tr>
                        </thead>
                        <tbody> <?php foreach ($transactions as $t): ?> <tr>
                                <td><?= h($t['category_name']) ?></td>
                                <td class="text-danger">¥<?= number_format($t['amount']) ?></td>
                                <td><?= h($t['payment_type']) ?></td>
                                <td><?= h($t['memo']) ?></td>
                                <td><?= h($t['date']) ?></td>
                                <td>
                                    <form action="../../Models/delete_transaction.php" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                        <input type="hidden" name="id" value="<?= h($t['id']) ?>">
                                        <button type="submit" class="btn-danger">削除</button>
                                    </form>
                                </td>
                            </tr> <?php endforeach; ?> </tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer>
            <p>&copy; 2025 MyWebsite</p>
        </footer>
    </body>
</html>
