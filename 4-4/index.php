<?php
require_once 'assets/init.php';

$tableName = getParam('tableName');
$action = getParam('action');
$fieldName = getParam('fieldName');

if (!empty($tableName) && !empty($fieldName)
    && (!empty(getParam('newFieldName')) or !empty(getParam('newFieldType')) or ($action === 'del'))) {
    $dataBase->getTable($tableName)->changeField(
        $action,
        $fieldName,
        getParam('newFieldName'),
        getParam('newFieldType')
    );
    redirect('index', '?tableName=' . $tableName);
}

if (!empty($tableName) && !empty(getParam('addFieldName')) && !empty(getParam('add'))) {
    $dataBase->getTable($tableName)->addField(getParam('addFieldName'), getParam('addFieldType'));
    redirect('index', '?tableName=' . $tableName);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Домашнее задание к лекции 4.4 «Управление таблицами и базами данных»</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity=
    "sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="row">
    <div class="col-xs-12 text-center">
        <h2>Управление таблицами</h2>
        <div class="row">
            <h3>База данных <?= DB ?> содержит таблицы:</h3>
            <div class="col-xs-4 col-xs-push-4 text-center">
                <ul class="list-unstyled">
                    <?php
                    foreach ($dataBase->getTables() as $table) {
                        echo '<li><a class="btn btn-default btn-block" href="?tableName=' . $table->getTableName() .
                            '">' . $table->getTableName() . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-xs-push-4 text-center">
                <?php if (!empty(getParam('tableName'))): ?>
                    <form action="index.php" method="GET">
                        <h3>Таблица <?= getParam('tableName') ?> содержит поля:</h3>
                        <table class="table table-bordered">
                            <tr class="active">
                                <td>Название (name)</td>
                                <td>Тип (type)</td>
                                <td>Редактировать</td>
                            </tr>
                            <?php
                            foreach ($dataBase->getTable(getParam('tableName'))->getFields() as $field) {
                                $link = '?tableName=' . getParam('tableName') . '&fieldName=' . $field->getName();
                                $editMode = (getParam('fieldName') === $field->getName());
                                echo '<tr>';
                                echo '  <td>';
                                if ($editMode && getParam('action') === 'editName') {
                                    echo '<input class="form-control input-sm" type="text" name="newFieldName" value="'
                                        . $field->getName() . '"/>';
                                } else {
                                    echo $field->getName();
                                }
                                echo '  </td>';
                                echo '  <td>';
                                if ($editMode && getParam('action') === 'editType') {
                                    echo '    <label title="">';
                                    echo '      <select class="form-control input-sm" name="newFieldType">';
                                    foreach ($dataBase->getTable(getParam('tableName'))->getFieldTypes() as $fieldType) :
                                        echo '        <option value="' . $fieldType . '">' . $fieldType . '</option>';
                                    endforeach;
                                    echo '      </select>';
                                    echo '    </label>';
                                } else {
                                    echo $field->getType();
                                }
                                echo '  </td>';
                                echo '  <td>';
                                if (!$editMode) {
                                    echo '    <a class="btn btn-default btn-sm" href="' . $link . '&action=editName">Изменить имя</a>';
                                    echo '    <a class="btn btn-default btn-sm" href="' . $link . '&action=editType">Изменить тип</a>';
                                    echo '    <a class="btn btn-default btn-sm" href="' . $link . '&action=del">Удалить</a>';
                                } else {
                                    echo '    <input class="form-control" type="hidden" name="tableName" value="' .
                                        getParam('tableName') . '">';
                                    echo '    <input class="form-control" type="hidden" name="fieldName" value="' .
                                        getParam('fieldName') . '">';
                                    echo '    <input class="form-control" type="hidden" name="action" value="' .
                                        getParam('action') . '">';
                                    echo '    <input class="btn btn-default btn-sm" type="submit" name="save" value="Сохранить"/>';
                                }
                                echo '  </td>';
                                echo '</tr>';
                            }
                            echo '<tr>';
                            echo '  <td><input class="form-control input-sm" type="text" name="addFieldName" value=""/></td>';
                            echo '  <td>';
                            echo '    <label title="">';
                            echo '      <select class="form-control input-sm" name="addFieldType">';
                            foreach ($dataBase->getTable(getParam('tableName'))->getFieldTypes() as $fieldType) :
                                echo '        <option value="' . $fieldType . '">' . $fieldType . '</option>';
                            endforeach;
                            echo '      </select>';
                            echo '    </label>';
                            echo '  </td>';
                            echo '  <td>';
                            echo '    <input type="hidden" name="tableName" value="' . getParam('tableName') . '">';
                            echo '    <input class="btn btn-default btn-sm" type="submit" name="add" value="Добавить поле"/>';
                            echo '  </td>';
                            echo '</tr>';
                            ?>
                        </table>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>