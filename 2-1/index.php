<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Задание к лекции "Установка и настройка веб-сервера"</title>
        <meta name="description" content="Нетология. Курс PHP/SQL. Урок 2.1">
        <link rel="stylesheet" type="text/css" href="http://university.netology.ru/u/balabanov/me/style_table.css" >
    </head>
    <body>
        <?php
        $data = file_get_contents(__DIR__ . '/phonebook.json');
        $phonebook = json_decode($data, true);
        ?>
        <table class="simple-little-table" cellspacing='0'>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Адрес</th>
                <th>Телефон</th>
            </tr>
            <?php foreach ($phonebook as $contact) : ?>
                <tr>
                    <td><?php echo $contact['firstName']; ?></td>
                    <td><?php echo $contact['lastName']; ?></td>
                    <td><?php echo $contact['address']; ?></td>
                    <td><?php echo $contact['phoneNumber']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>