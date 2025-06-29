<?php
// セッションの開始
session_start();

// セッションの全データを削除
$_SESSION = [];

// セッション自体を削除
session_destroy();

// ログインページにリダイレクト
header('Location: ../view/login/login.php');
exit;
