<?php
declare(strict_types=1);
require_once(dirname(__DIR__) . '/DB.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    exit('ログインしてください');
}

$user_id = $_SESSION['user']['id'];

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    exit('画像のアップロードに失敗しました');
}

// 保存先の絶対パス
$uploadDir = __DIR__ . '../../../images/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$tmpFile = $_FILES['image']['tmp_name'];
$originalName = basename($_FILES['image']['name']);
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

$allowed = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($ext, $allowed)) {
    exit('画像形式は jpg/jpeg/png/gif のみ対応しています');
}

$newFileName = uniqid('img_', true) . '.' . $ext;
$destination = $uploadDir . $newFileName;

if (move_uploaded_file($tmpFile, $destination)) {
    try {
        $db = new DB();
        $pdo = $db->getPDO();

        // DBにはWebパスとして保存（../../images/ではなく images/）
        $stmt = $pdo->prepare("INSERT INTO user_images (user_id, file_path) VALUES (?, ?)");
        $stmt->execute([$user_id, 'images/' . $newFileName]);

        // 成功後リダイレクト
        header('Location: /practice/07_house_number/view/mypage/mypage.php');
        exit;
    } catch (PDOException $e) {
        exit('DB登録エラー: ' . $e->getMessage());
    }
} else {
    exit('ファイルの保存に失敗しました: ' . $destination);
}
