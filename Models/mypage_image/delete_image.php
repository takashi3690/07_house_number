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
$image_id = $_POST['image_id'] ?? null;

if (!$image_id) {
    exit('不正なリクエストです');
}

try {
    $db = new DB();
    $pdo = $db->getPDO();

    // まず、該当画像のパスを取得してファイル削除のために使う
    $stmt = $pdo->prepare("SELECT file_path FROM user_images WHERE id = ? AND user_id = ?");
    $stmt->execute([$image_id, $user_id]);
    $image = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$image) {
        exit('画像が見つかりません');
    }

    $file_path = __DIR__ . '/../' . $image['file_path'];

    // ファイルが存在すれば削除
    if (file_exists($file_path)) {
        unlink($file_path);
    }

    // DBからも削除
    $stmt = $pdo->prepare("DELETE FROM user_images WHERE id = ? AND user_id = ?");
    $stmt->execute([$image_id, $user_id]);

    header('Location: /practice/07_house_number/view/mypage/mypage.php');
    exit;

} catch (PDOException $e) {
    exit('エラーが発生しました: ' . $e->getMessage());
}
