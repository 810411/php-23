<?php
require_once 'assets/init.php';

if ($user->getCurrentUser()) {
    redirect('index');
}

if (isPost()) {
    if ((getParam('sign_in') && $user->checkForLogin(getParam('login'), getParam('password'))) OR
        (getParam('register') && $user->register(getParam('login'), getParam('password')))) {
        redirect('index');
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Домашнее задание к лекции 4.3 «SELECT из нескольких таблиц»</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container text-center">
    <div class="col-xs-4 col-xs-push-4">
        <div class="row">
            <hr>
        </div>
        <div class="row">
            <span class="lead">Введите данные для регистрации</span>
            <span class="lead">или войдите, если уже регистрировались:</span>
        </div>
        <div class="row">
            <hr>
        </div>
        <?php
        if (!empty($user->getLoginErrors())) {
            foreach ($user->getLoginErrors() as $error) {
                echo "<p>$error</p>";
            }
        }
        ?>
        <form method="POST">
            <div class="form-group row">
                <label for="login" class="col-xs-2 col-form-label col-form-label-lg">Логин</label>
                <div class="col-xs-10">
                    <input class="form-control form-control-lg" type="text" name="login" id="login">
                </div>
            </div>
            <div class="form-group row">
                <label for="pass" class="col-xs-2 col-form-label col-form-label-lg">Пароль</label>
                <div class="col-xs-10">
                    <input class="form-control form-control-lg" type="password" name="password" id="pass">
                </div>
            </div>
            <input type="submit" class="btn btn-success btn-lg btn-block" name="sign_in" value="Вход">
            <input type="submit" class="btn btn-info btn-lg btn-block" name="register" value="Регистрация"/>
        </form>
        <div class="row">
            <hr>
        </div>
    </div>
</div>
</body>
</html>