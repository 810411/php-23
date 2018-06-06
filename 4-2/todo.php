<?php
try {
    //$pdo = new PDO("mysql:host=localhost;dbname=balabanov;charset=UTF8","********","********");
    $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=global;charset=UTF8","mysql","mysql");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

if (!empty($_GET['id']) && !empty($_GET['action'])) {
    if (($_GET['action'] == 'edit') && !empty($_POST['description'])) {
        $sql = "UPDATE tasks SET description = ?, is_done = 0 WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(["{$_POST['description']}", "{$_GET['id']}"]);
        header( 'Location: ./todo.php');
    } else {
        $sql = "SELECT * FROM tasks";
    }

    if ($_GET['action'] == 'done') {
        $sql = "UPDATE tasks SET is_done = 1 WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(["{$_GET['id']}"]);
        header( 'Location: ./todo.php');
    }

    if ($_GET['action'] == 'delete') {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute(["{$_GET['id']}"]);
        header( 'Location: ./todo.php');
    }
}

if (!empty($_POST['description']) && empty($_GET['action'])) {
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO  tasks (description, date_added) VALUES (?, ?)";
    $statement = $pdo->prepare($sql);
    $statement->execute(["{$_POST['description']}", "{$date}"]);
}

if (!empty($_POST['sort']) && !empty($_POST['sort_by'])) {
    $sql = "SELECT * FROM tasks ORDER BY {$_POST['sort_by']} ASC";
    $statement = $pdo->prepare($sql);
    $statement->execute();
} else {
    $sql = "SELECT * FROM tasks";
    $statement = $pdo->prepare($sql);
    $statement->execute();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Домашнее задание к лекции 4.2 «Запросы SELECT, INSERT, UPDATE и DELETE»</title>
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
</head>
<body>
<h1>Список дел на сегодня</h1>
<div style="float: left">
<form method="POST">
    <input type="text" name="description" placeholder="Описание задачи" value="<?php if (!empty($_GET['description'])) echo $_GET['description']; ?>">
    <input type="submit" name="save" value="Добавить">
</form>
</div>
<div style="float: left; margin-left: 20px;">
<form method="POST">
    <label for="sort">Сортировать по:</label>
    <select name="sort_by">
        <option value="date_added">Дате добавления</option>
        <option value="is_done">Статусу</option>
        <option value="description">Описанию</option>
    </select>
    <input type="submit" name="sort" value="Отсортировать">
</form>
</div>
<div style="clear: both"><br></div>

<table>
    <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th></th>
    </tr>
    <?php foreach ($statement as $row) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
            <td <?php if ($row['is_done'] == 1) echo 'style="color: green;"'; ?>>
                <?php if ($row['is_done'] == 0) {
                    echo '<span style="color: orange">' . 'В процессе' . '</span>';
                } else {
                    echo '<span style="color: green">' . 'Выполнено' . '</span>';
                } ?>
            </td>
            <td>
                <a href="?id=<?php echo $row['id']; ?>&action=edit&description=<?php echo $row['description']; ?>">Изменить</a>
                <a href="?id=<?php echo $row['id']; ?>&action=done">Выполнить</a>
                <a href="?id=<?php echo $row['id']; ?>&action=delete">Удалить</a>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>