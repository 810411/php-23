<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Задание к лекции "Обработка форм"</title>
    <meta name="description" content="Нетология. Курс PHP/SQL. Урок 2.2">
</head>
<body>
<?php $fileList = glob(__DIR__ . '/uploads/*.json'); ?>
<ul>
    <li><a href="admin.php">Загрузчик тестов</a></li>
    <?php foreach ($fileList as $key => $file) : ?>
        <?php $name = pathinfo($file)['filename']; ?>
        <li><?php echo "<a href=\"test.php?test=$key\"\>$name</a>"; ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>