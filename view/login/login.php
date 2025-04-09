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
                <div class="login-form">
                    <div class="control-group">
                        <input type="text" class="login-field" value="" placeholder="ユーザー名" id="login-name">
                        <label class="login-field-icon fui-user" for="login-name"></label>
                    </div>
                    <div class="control-group">
                        <input type="password" class="login-field" value="" placeholder="パスワード" id="login-pass">
                        <label class="login-field-icon fui-lock" for="login-pass"></label>
                    </div>
                    <a class="btn btn-primary btn-large btn-block" href="/carendar/carendar.php">ログイン</a>
                    <a class="login-link" href="register.php">登録がまだの方はこちら</a>
                </div>
            </div>
        </div>
    </body>
</html>
