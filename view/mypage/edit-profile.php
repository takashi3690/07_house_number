<?php
session_start();
require_once __DIR__ . '../../../Models/carendar.php';
require_once __DIR__ . '../../../Models/mypage_image/mypage_image.php'; // ここで $image を取得している想定
require_once __DIR__ . '../../../Models/hsc.php';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../../css/style.css" />
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
                        <div class="profile-image"> <?php if (isset($image) && !empty($image['file_path'])): ?> <img src="../../<?= h($image['file_path']) ?>" alt="プロフィール画像">
                            <!-- 削除フォームは画像がある場合だけ表示 -->
                            <form action="../../Models/mypage_image/delete_image.php" method="POST" onsubmit="return confirm('本当に画像を削除しますか？');" style="margin-top:10px;">
                                <input type="hidden" name="image_id" value="<?= h($image['id']) ?>">
                                <button type="submit" class="btn-btn-danger">画像を削除</button>
                            </form> <?php else: ?> <p><img src="../../images/list-kuromi.png" alt="デフォルト画像"></p> <?php endif; ?>
                            <!-- アップロードフォームは常に表示 -->
                            <form action="../../Models/mypage_image/upload_mypage.php" method="POST" enctype="multipart/form-data" class="mt-3">
                                <input type="file" name="image" accept="image/*" required>
                                <button type="submit" class="btn-btn-image-primary">画像を登録</button>
                            </form>
                        </div>
                        <form action="../../Models/edit_profile.php" method="POST">
                            <table class="user-data-table">
                                <tr>
                                    <td class="label">名前:</td>
                                    <td><input type="text" name="username" value="<?php echo h($_SESSION['user']['username']); ?>" required></td>
                                </tr>
                                <tr>
                                    <td class="label">メール:</td>
                                    <td><input type="email" name="email" value="<?php echo h($_SESSION['user']['email']); ?>" required></td>
                                </tr>
                            </table>
                            <button class="btn-btn-primary" type="submit">更新</button>
                        </form>
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
