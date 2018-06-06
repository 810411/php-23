<?php

try {
    //$pdo = new PDO("mysql:host=localhost;dbname=global;charset=UTF8","balabanov","neto1744");
    $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=global;charset=UTF8","mysql","mysql");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$isbn="";
if (isset($_GET['isbn'])) {
    $isbn=trim($_GET['isbn']);
}

$name="";
if (isset($_GET['name'])) {
    $name=trim($_GET['name']);
}

$author="";
if (isset($_GET['author'])) {
    $author=trim($_GET['author']);
}

if (isset($_GET['isbn']) or isset($_GET['author']) or isset($_GET['name'])) {
    $sql = "select * FROM books WHERE isbn LIKE '%{$isbn}%' and author LIKE '%{$author}%' and name LIKE '%{$name}%'";
}
else {
    $sql = "SELECT * FROM books";
}

?>

<html>
<header>
    <title>Домашнее задание к лекции 4.1 «Реляционные базы данных и SQL»</title>
    <style>
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        table td, table th {
            border: 1px solid #ccc;
            padding: 5px;
        }
        table th {
            background: #eee;
        }
    </style>
</header>
<body>
<h1>Библиотека успешного человека</h1>
<form method="GET">
    <input type="text" name="isbn" placeholder="ISBN" value="<?php echo $isbn; ?>">
    <input type="text" name="name" placeholder="Название книги" value="<?php echo $name; ?>">
    <input type="text" name="author" placeholder="Автор книги" value="<?php echo $author; ?>">
    <input type="submit" value="Поиск">
</form>
<table>
    <thead>
    <th>Название</th>
    <th>Автор</th>
    <th>Год выпуска</th>
    <th>Жанр</th>
    <th>ISBN</th>
    </thead>
    <tbody>
    <?php foreach ($pdo->query($sql) as $row) : ?>
        <tr>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['author'] ?></td>
            <td><?php echo $row['year'] ?></td>
            <td><?php echo $row['genre'] ?></td>
            <td><?php echo $row['isbn'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>