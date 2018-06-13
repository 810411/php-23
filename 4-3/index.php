<?php
require_once 'assets/init.php';

if (!$user->getCurrentUser()) {
    redirect('register');
}

if (!empty(getParam('description')) && empty(getParam('action'))) {
    $user->changeTask(0, 'add', getParam('description'));
}

if (!empty(getParam('sort_by'))) {
    $user->setSortType(getParam('sort_by'));
}

if (!empty(getParam('id')) && !empty(getParam('action'))) {
    $user->changeTask(
        (int)getParam('id'),
        getParam('action'),
        getParam('description')
    );
}

if (!empty(getParam('assigned_user_id'))) {
    $str = explode('-', getParam('assigned_user_id'));
    $assigned_user_id = (int)str_replace('user_', '', $str[0]);
    $taskID = (int)str_replace('task_', '', $str[1]);
    $user->changeTask($taskID, 'set_assigned_user', null, $assigned_user_id);
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
    <div class="col-xs-12">
        <div class="row">
            <hr>
        </div>
        <div class="row alert alert-success">
            <div class="col-xs-8 col-xs-push-2 text-center">
                <span class="lead">Здравствуйте, <?= $user->getUserName() ?>!</span>
            </div>
            <div class="col-xs-2 text-center">
                <a class="btn btn-warning btn-block" href="./logout.php">Выход</a>
            </div>
        </div>
        <div class="row">
            <h2>Список дел на сегодня</h2><br>
            <div class="form-group col-xs-6 text-center">
                <form class="form-inline" method="POST">
                    <input class="form-control" type="text" name="description" placeholder="Описание задачи"
                           value="<?= getParam('action') === 'edit' ?
                               $user->getDescriptionForTask((int)getParam('id')) : '' ?>"/>
                    <input class="btn btn-success" type="submit" name="save"
                           value="<?= getParam('action') === 'edit' ? 'Сохранить' : 'Добавить' ?>"/>
                </form>
            </div>
            <div class="form-group col-xs-6 text-center">
                <form class="form-inline" method="POST">
                    <label class="custom-select text-muted">Сортировать по:
                        <select class="form-control" name="sort_by">
                            <option <?= $user->getSortType() === 'date_created' ? 'selected' : '' ?>
                                    value="date_created">Дате
                                добавления
                            </option>
                            <option <?= $user->getSortType() === 'is_done' ? 'selected' : '' ?> value="is_done">
                                Статусу
                            </option>
                            <option <?= $user->getSortType() === 'description' ? 'selected' : '' ?>
                                    value="description">
                                Описанию
                            </option>
                        </select>
                    </label>
                    <input class="btn btn-success" type="submit" name="sort" value="Отсортировать"/>
                </form>
            </div>
            <div>
                <table class="table table-bordered table-sm">
                    <tr class="alert alert-warning">
                        <td>Описание задачи</td>
                        <td>Дата добавления</td>
                        <td>Статус</td>
                        <td>Управление задачей</td>
                        <td>Ответственный</td>
                        <td>Автор</td>
                        <td>Закрепить задачу за пользователем</td>
                    </tr>
                    <?php foreach ($user->getOwnerTasks() as $task) : ?>
                        <tr>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td><?= $task['date_added'] ?></td>
                            <td>
                                <span style='color: <?= $user->getStatusColor($task['is_done']) ?>;'><?= $user->getStatusName($task['is_done']) ?></span>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-sm"
                                   href='?id=<?= $task['id'] ?>&action=edit'>Изменить</a>
                                <?php if ($task['assigned_user_login'] === $user->getUserName()) : ?>
                                    <a class="btn btn-warning btn-sm"
                                       href='?id=<?= $task['id'] ?>&action=done'>Выполнить</a>
                                <?php endif; ?>
                                <a class="btn btn-warning btn-sm"
                                   href='?id=<?= $task['id'] ?>&action=delete'>Удалить</a>
                            </td>
                            <td><?= $task['assigned_user_login'] ?></td>
                            <td><?= $task['owner_user_login'] ?></td>
                            <td>
                                <form class="form-inline" method='POST'>
                                    <label class="custom-select" title="Выберите пользователя из списка">
                                        <select class="form-control" name='assigned_user_id'>
                                            <?php foreach ($user->getUserList() as $currentUser) : ?>
                                                <option <?= $currentUser['login'] === $task['assigned_user_login'] ? 'selected' : '' ?>
                                                        value="<?= $user->getNameOptionList($currentUser['id'], $task['id']) ?>"><?= $currentUser['login'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </label>
                                    <input class="btn btn-info btn-sm" type='submit' name='assign'
                                           value='Переложить ответственность'/>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
            <div class="row">
                <hr>
            </div>
            <h3>Также, посмотрите, что от Вас требуют другие люди:</h3>
            <div>
                <table class="table table-bordered table-sm">
                    <tr class="alert alert-warning">
                        <td>Описание задачи</td>
                        <td>Дата добавления</td>
                        <td>Статус</td>
                        <td>Управление задачей</td>
                        <td>Ответственный</td>
                        <td>Автор</td>
                    </tr>
                    <?php foreach ($user->getOtherTasks() as $task) : ?>
                        <tr>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td><?= $task['date_added'] ?></td>
                            <td>
                                <span style='color: <?= $user->getStatusColor($task['is_done']) ?>;'><?= $user->getStatusName($task['is_done']) ?></span>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-sm" href='?id=<?= $task['id'] ?>&action=edit'>Изменить</a>

                                <?php if ($task['assigned_user_login'] === $user->getUserName()): ?>
                                    <a class="btn btn-warning btn-sm" href='?id=<?= $task['id'] ?>&action=done'>Выполнить</a>
                                <?php endif; ?>

                                <a class="btn btn-warning btn-sm"
                                   href='?id=<?= $task['id'] ?>&action=delete'>Удалить</a>
                            </td>
                            <td><?= $task['assigned_user_login'] ?></td>
                            <td><?= $task['owner_user_login'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="row">
                <hr>
            </div>
        </div>
    </div>
</div>
</body>
</html>
