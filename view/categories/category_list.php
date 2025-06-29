<?php
session_start();
require_once __DIR__ . '../../../Models/categories/category.php';
require_once __DIR__ . '../../../Models/hsc.php';

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/style.css">
        <title>カテゴリ</title>
    </head>
    <body class="my-container">
        <div class="container">
            <header>
                <h1>カテゴリ一覧</h1>
            </header>
            <div class="main-content">
                <aside class="sidebar">
                    <ul>
                        <li><a href="../carendar/carendar.php">Home</a></li>
                        <li><a href="../../Models/logout.php">ログアウト</a></li>
                        <li><a href="../mypage/mypage.php">マイページ</a></li>
                        <li><a href="../categories/category_list.php">カテゴリ管理</a></li>
                        <li><a href="../carendar/budget.php">予算設定</a></li>
                        <li><a href="../carendar/transactions.php">支出登録</a></li>
                    </ul>
                </aside>
                <section class="profile-section">
                    <div class="category-list">
                        <table> <?php foreach ($categories as $category): ?> <tr>
                                <td><?= h($category["name"]) ?></td>
                                <td>
                                    <a href="edit_category.php?id=<?= htmlspecialchars($category['id']) ?>" class="category-edit-btn">変更</a>
                                    <form action="../../Models/categories/delete_category.php" method="post" onsubmit="return confirm('本当に削除しますか？');" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
                                        <button type="submit" class="category-delete-btn">削除</button>
                                    </form>
                                </td>
                            </tr> <?php endforeach; ?> </table>
                        </div>
                        <div colspan="2" style="text-align: center;" class="profile-actions"><a href="add_category.php" class="btn-btn-primary">カテゴリを追加</a></div>
                    </section>
            </div>
            <footer>
            <p>&copy; 2025 MyWebsite</p>
        </footer>
    </body>
</html>
