<?php

declare(strict_types=1);
require_once(dirname(__FILE__) . '/DB.php');

// 初期値設定
$register_name = '';
$register_email = '';
$register_pass = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // var_dump($_POST);
    // ユーザーが入力したデータを取得
    $register_name = $_POST['register_name'] ?? '';
    $register_email = $_POST['register_email'] ?? '';
    $register_pass = $_POST['register_password'] ?? '';

    try {
        // ユーザー名のバリデーション（正規表現）
        if (empty($register_name) || !preg_match('/^[A-Za-z0-9一-龯ぁ-んァ-ヶ々ー]{3,}$/', $register_name)) {
            $errors[] = "ユーザー名は3文字以上、20文字以内で、アルファベット（大文字・小文字）、数字、ハイフン（-）やアンダースコア（_）のみ使用できます。";
        }

        // メールアドレスのバリデーション（正規表現）
        if (empty($register_email) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $register_email)) {
            $errors[] = "有効なメールアドレスではありません。";
        }

        // パスワードのバリデーション（正規表現）
        if (empty($register_pass) || !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $register_pass)) {
            $errors[] = "パスワードは6文字以上で、英字と数字を両方含む必要があります。";
        }

        // エラーがない場合はデータベースに登録
        if (empty($errors)) {
            $db = new DB;
            $pdo = $db->getPDO();
            $stmt = $pdo->prepare('
                INSERT INTO users(username, email, password, created_at)
                VALUES(:username, :email, :password, NOW())'
            );

            $hashed_password = password_hash($register_pass, PASSWORD_DEFAULT);
            // パラメータバインディング
            $stmt->bindParam(':username', $register_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $register_email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: login.php");
            exit();
        }

    } catch (PDOException $e) {
        // DB接続エラーなどが発生した場合はエラーメッセージを表示
        header('Content-Type: text/plain; charset=UTF-8', true, 500);
        exit($e->getMessage());
    }
}
?>
