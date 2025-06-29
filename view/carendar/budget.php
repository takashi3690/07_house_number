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
                        <li><a href="transactions.php">支出登録</a></li>
                    </ul>
                </aside>
                <section class="profile-section">
                    <div class="budget-list">
                        <h2></h2>
                        <form action="../../Models/budget.php" method="POST" class="budget-form">
                            <div class=form-row>
                                <label for="category_id" class="form-label">カテゴリ:</label>
                                <select name="category_id" id="category_id" required class="form-select">
                                    <option value="">選択してください</option> <?php foreach ($categories as $category): ?> <option class="form-option" value="<?= h($category['id']) ?>"> <?= h($category['name']) ?> </option> <?php endforeach; ?>
                                </select>
                            </div>
                            <div class=form-row>
                                <label for="month" class="form-label">月（例: 2025-06）:</label>
                                <input type="month" name="month" id="month" required class="form-input">
                            </div>
                            <div class=form-row>
                                <label for="amount" class="form-label">金額（円）:</label>
                                <input type="number" name="amount" id="amount" required class="form-input">
                            </div><button type="submit" class="form-button">予算を登録/更新</button>
                        </form>
                    </div>
                </section>
            </div>
            <footer>
            <p>&copy; 2025 MyWebsite</p>
        </footer>
    </body>
</html>
