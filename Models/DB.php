<?php
// Dotenv機能の読み込み(階層のズレに注意)
require_once dirname(__FILE__) . '/../vendor/autoload.php';
// Dotenvクラスの使用の宣言
use Dotenv\Dotenv;

class DB {

    protected $pdoObj;

    public function __construct()
    {
        $env = Dotenv::createImmutable(__DIR__ . '/../')->load();
        try {
            $this->pdoObj = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . '; dbname=' . $_ENV['DB_NAME'] . '; charset=utf8',
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'],
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            exit($e->getMessage('データベース接続エラーが発生しました。'));
        }

    }

    // PDOオブジェクトを取得するメソッド
    public function getPDO()
    {
        return $this->pdoObj;
    }
}
