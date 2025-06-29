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
                        <li><a href="mypage.php">マイページ</a></li>
                        <li><a href="../categories/category_list.php">カテゴリ管理</a></li>
                        <li><a href="../carendar/budget.php">予算設定</a></li>
                        <li><a href="../transactions.php">支出登録</a></li>
                    </ul>
                </aside>
                <section class="profile-section">
                    <div class="category-list">
                        <form action="../../Models/categories/add_category.php" method="post" novalidate>
                            <input type="text" name="name" placeholder="カテゴリ名">
                            <p><input type="submit" value="送信" class="add-category-btn"></p>
                        </form>
                    </div>
                </section>
            </div>
            <footer>
            <p>&copy; 2025 MyWebsite</p>
        </footer>
    </body>
</html>
