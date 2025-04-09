<?php
require_once __DIR__ . '../../../Models/login.php';
require_once __DIR__ . '../../../Models/hsc.php';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/style.css">
        <title>ログイン画面</title>
    </head>
    <body class="home-page">
        <div class="login">
            <div class="login-screen">
                <div class="app-title">
                    <h1>Login</h1>
                </div>
                <form action="login.php" method="post" novalidate> <?php if (!empty($errors)): ?> <div class="error-messages"> <?php foreach ($errors as $error): ?> <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p> <?php endforeach; ?> </div> <?php endif; ?> <div class="login-form">
                        <div class="control-group">
                            <input type="text" class="login-field" value="<?php echo h($login_email)?>" placeholder="メール" id="login_email" name="login_email">
                            <label class="login-field-icon fui-user" for="login_email"></label>
                        </div>
                        <div class="control-group">
                            <input type="password" class="login-field" value="<?php echo h($login_pass)?>" placeholder="パスワード" id="login_pass" name="login_pass">
                            <label class="login-field-icon fui-lock" for="login_pass"></label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-large btn-block">ログイン</button>
                        <a class="login-link" href="register.php">登録がまだの方はこちら</a>
                    </div>
                    </from>
            </div>
        </div>
    </body>
</html>
