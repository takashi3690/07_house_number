<?php

declare(strict_types=1);
session_start();
require_once(dirname(__FILE__) . '/DB.php');


$errors = [];
$login_email = '';
$login_pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

try {

$email = $_POST['login_email'] ?? '';
$pass = $_POST['login_pass'] ?? '';

$db = new DB();
$pdo = $db->getPDO();

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch();
if (!$user) {
    $errors[] = 'メールアドレスが登録されていません';
} elseif (!password_verify($pass, $user['password'])) {
    // パスワードが間違っている場合
    $errors[] = 'パスワードが間違っています';
}

$_SESSION['user'] = [
    'id'    => $user['id'],
    'username'  => $user['username'],
    'email' => $user['email']
];

header('Location: ../carendar/carendar.php');
exit;

} catch (PDOException $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}
}


?>
