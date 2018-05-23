<?php
require_once 'functions.php';

if (!empty($_SESSION['login'])) {
    echo '<h3>' . $_SESSION['name'] . ', вы вошли как зарегистрированный пользователь</h3>';
} elseif (!empty($_SESSION['name'])) {
    echo '<h3>' . $_SESSION['name'] . ', вы вошли как гость</h3>';
} else {
    header('HTTP/1.1 403 Forbidden');
    echo '<h3>HTTP 403 (Forbidden)</h3>';
    echo '<h3>Доступ запрещен</h3>';
    exit(0);
}

$fileList = glob(__DIR__ . '/uploads/*.json');

if (array_key_exists('test', $_POST)) {
    if (array_key_exists('delete', $_POST)) {
        if ($_POST['delete']) {
            unlink($_POST['test']);
            location('list');
        }
    } elseif ($_POST['test']) {
        header('Location: test.php?test=' . $_POST['test']);
        die;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Задание к занятию «Куки, сессии и авторизация»</title>
    <meta name="description" content="Нетология. Курс PHP/SQL. Урок 2.4">
</head>
<body>
<?php if (!empty($_SESSION['login'])) : ?>
    <form action="redirect.php" method="POST" enctype="multipart/form-data">
        <label>Добавить тест:<br><input type="file" name="json"></label><br>
        <input type="submit" value="Отправить"><br>
    </form>
<?php endif; ?>
<?php if (isset($fileList)) : ?>
    <form action="list.php" method="POST">
        <fieldset>
            <legend>Выбрать тест:</legend>
            <?php foreach ($fileList as $key => $file) : ?>
                <?php $name = pathinfo($file)['filename']; ?>
                <label><input type="radio" name="test" value="<?= $file; ?>"> <?php echo $name ?></label><br>
            <?php endforeach; ?>
        </fieldset>
        <?php if (!empty($_SESSION['login'])) : ?>
            <label>Удалить тест! <input type="checkbox" name="delete"></label><br>
        <?php endif; ?>
        <input type="submit" value="Отправить">
    </form>
<?php endif; ?>
<a href="logout.php">
    <button>Выход</button>
</a>
</body>
</html>