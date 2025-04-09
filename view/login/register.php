<?php
require_once __DIR__ . '../../../Models/register.php';
require_once __DIR__ . '../../../Models/hsc.php';
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../css/style.css">
        <title>登録画面</title>
    </head>
    <body>
        <div class="register">
            <div class="register-screen">
                <div class="app-title">
                    <h1>Register</h1>
                </div>
                <div class="register-form">
                    <form action="" method="POST"> <?php if (!empty($errors)): ?> <div class="error-messages"> <?php foreach ($errors as $error): ?> <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p> <?php endforeach; ?> </div> <?php endif; ?> <div class="control-group">
                            <input type="text" class="register-field" value="<?php echo h($register_name); ?>" name="register_name" id="register_name" placeholder="ユーザー名" required>
                            <label class="register-field-icon fui-user" for="register_name"></label>
                        </div>
                        <div class="control-group">
                            <input type="email" class="register-field" value="<?php echo h($register_email); ?>" name="register_email" placeholder="メールアドレス" id="register_email" required>
                            <label class="register-field-icon fui-email" for="register_email"></label>
                        </div>
                        <div class="control-group">
                            <input type="password" class="register-field" value="<?php echo h($register_pass); ?>" name="register_password" placeholder="パスワード" id="register_pass" required>
                            <label class="register-field-icon fui-lock" for="register_pass"></label>
                        </div>
                        <input type="submit" class="btn btn-primary btn-large btn-block" value="登録" name="register"></input>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
