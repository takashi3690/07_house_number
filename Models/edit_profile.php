<?php
declare(strict_types=1);
require_once(dirname(__FILE__) . '/DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: /login.php'); // 未ログインはリダイレクト
    exit;
}

$user_id = $_SESSION['user']['id'];

$db = new DB();
$pdo = $db->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTで送られてきた編集内容を受け取る
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    // 簡単なバリデーション
    if ($username === '' || $email === '') {
        echo "名前とメールは必須です。";
        exit;
    }

    // 更新処理
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $user_id]);

        $pdo->commit();

        // セッション情報も更新
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;

        // 更新成功後にリダイレクトやメッセージ表示
        header("Location: /practice/07_house_number/view/mypage/mypage.php");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "更新中にエラーが発生しました: " . htmlspecialchars($e->getMessage());
        exit;
    }

} else {
    // GETアクセス時はユーザー情報をDBから取得し、セッションにセット
    $stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "ユーザー情報が見つかりません。";
        exit;
    }

    $_SESSION['user']['username'] = $user['username'];
    $_SESSION['user']['email'] = $user['email'];
}
