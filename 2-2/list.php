<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Задание к лекции "Обработка форм"</title>
        <meta name="description" content="Нетология. Курс PHP/SQL. Урок 2.2">
    </head>
    <body>
    <?php $file_list = glob(__DIR__ . '/*.json'); ?>
    <ul>
        <li><a href="admin.php">Загрузчик тестов</a></li>
        <?php foreach ($file_list as $key => $file) : ?>
        <?php $name = pathinfo($file)['filename']; ?>
        <li><?php echo "<a href=\"test.php?test=$key\"\>$name</a>"; ?></li>
        <?php endforeach; ?>
    </ul>
    </body>
</html>