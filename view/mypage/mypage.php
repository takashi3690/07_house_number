<?php

session_start();
require_once __DIR__ . '../../../Models/carendar.php';
require_once __DIR__ . '../../../Models/mypage_image/mypage_image.php';
require_once __DIR__ . '../../../Models/hsc.php';

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/style.css">
        <title>マイページ</title>
    </head>
    <body class="my-container">
        <div class="container">
            <!-- ヘッダー -->
            <header>
                <h1>マイページ</h1>
            </header>
            <!-- サイドバー + メインコンテンツ -->
            <div class="main-content">
                <!-- サイドバー -->
                <aside class="sidebar">
                    <ul>
                        <li><a href="../carendar/carendar.php">Home</a></li>
                        <li><a href="../../Models/logout.php">ログアウト</a></li>
                        <li><a href="mypage.php">マイページ</a></li>
                        <li><a href="../categories/category_list.php">カテゴリ管理</a></li>
                        <li><a href="../carendar/budget.php">予算設定</a></li>
                        <li><a href="../transactions.php">支出登録</a></li>
                    </ul>
                </aside>
                <!-- メインコンテンツ -->
                <section class="profile-section">
                    <h2>ユーザー情報</h2>
                    <div class="user-info">
                        <div class="profile-image"><?php if (isset($image) && !empty($image['file_path'])): ?> <img src="../../<?= h($image['file_path']) ?>" alt="プロフィール画像"> <?php else: ?> <p><img src="../../images/list-kuromi.png" alt=""></p> <?php endif; ?>
                        </div>
                        <div class="user-details">
                            <table class="user-data-table">
                                <tr>
                                    <td class="label">名前:</td>
                                    <td><?php echo h($_SESSION['user']['username']); ?></td>
                                </tr>
                                <tr>
                                    <td class="label">メール:</td>
                                    <td><?php echo h($_SESSION['user']['email']); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <h2>プロフィール編集</h2>
                    <div colspan="2" style="text-align: center;" class="profile-actions">
                        <a href="edit-profile.php" class="btn-btn-primary">プロフィールを編集</a>
                    </div>
                </section>
            </div>
            <!-- フッター -->
            <footer>
                <p>&copy; 2025 MyWebsite</p>
            </footer>
        </div>
    </body>
</html>
