<?php
session_start();
require_once __DIR__ . '../../../Models/budget.php';
require_once __DIR__ . '../../../Models/hsc.php';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/style.css">
        <title>予算設定</title>
    </head>
    <body class="my-container">
        <div class="container">
            <!-- ヘッダー -->
            <header>
                <h1>予算設定</h1>
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
                        <li><a class="current" href="javascript:void(0);">予算の管理</a></li>
                    </ul>
                </aside>
                <section class="profile-section">
                    <div class="budget-list">
                        <h2></h2>
                        <form action="../../Models/transaction_store.php" method="POST">
                            <div class="from-row">
                                <label>カテゴリ: <select name="category_id" required>
                                        <option value="">選択</option> <?php foreach ($categories as $category): ?> <option value="<?= h($category['id']) ?>"><?= h($category['name']) ?></option> <?php endforeach; ?>
                                    </select>
                                </label>
                            </div>
                            <div class="from-row">
                                <label>金額: <input type="number" name="amount" required>
                                </label>
                            </div>
                            <div class="from-row">
                                <label>支払い方法: <select name="payment_type" required>
                                        <option value="">選択</option>
                                        <option value="pay">電子決済（Pay系など）</option>
                                        <option value="gennkinn">現金</option>
                                    </select>
                                </label>
                            </div>
                            <div class="from-row">
                                <label>日付: <input type="date" name="date" required>
                                </label>
                            </div>
                            <div class="from-row">
                                <label>メモ: <input type="text" name="memo">
                                </label>
                            </div>
                            <button type="submit" class="form-button">登録</button>
                        </form>
                    </div>
                </section>
            </div>
            <footer>
                <p>&copy; 2025 MyWebsite</p>
            </footer>
    </body>
</html>
