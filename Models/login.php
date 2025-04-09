<?php

declare(strict_types=1);
require_once(dirname(__FILE__) . '/DB.php');

$errors = [];
$login_email = '';
$login_pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login_email = $_POST['login_email'] ?? '';
    $login_pass = $_POST['login_pass'] ?? '';

    if (empty($login_email) || empty($login_pass)) {
        $errors[] = "メールアドレスとパスワードは必須です。";
    }

    // エラーがなければ、ユーザー情報の照合
    if (empty($errors)) {
        try {

            $db = new DB;
            $pdo = $db->getPDO();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->bindParam(':email', $login_email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($login_pass, $user['password'])) {
                    header('Location: ../../view/carendar/carendar.php');
                } else {
                    echo 'ログインに失敗しました';
                }
        } catch (PDOException $e) {
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            exit($e->getMessage());
        }

    }
}






?>
