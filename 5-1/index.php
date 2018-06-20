<?php
require "assets/init.php";
@$searchResults = new Engine(getParam('address'), getParam('addressID'));
$lastSearchID = $searchResults->getLastSearchID();
$resultForMap = $searchResults->getItemByID($lastSearchID);
$searchQuery = (getParam('address') !== null OR getParam('addressID') !== null) ?
    $searchResults->getSearchQuery() : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Домашнее задание к лекции 5.1 «Менеджер зависимостей Composer»</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
</head>
<body>
<div class="container">
    <div class="text-center">
        <h2>Cервис по определению широты и долготы по адресу</h2>
        <hr>
        <div class="row">
            <div class="col-xs-8 col-xs-push-2">
                <form method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="address"
                               placeholder="Введите адрес, например: г. Москва, Красная площадь, 1"
                               value="<?= $searchQuery ?>"/>
                        <span class="input-group-btn">
                        <input type="submit" class="btn btn-default" name="find" value="Поиск по адресу">
                    </span>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <?php
        if ($searchResults->getFoundCount() > 0) : ?>
            <div class="row">
                <div class="col-xs-10 col-xs-push-1 text-justify">
                    <table class="table table-hover table-condensed">
                        <tr>
                            <th>Адрес</th>
                            <th>Координаты</th>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($searchResults->getList() as $item) :
                            ?>
                            <tr>
                                <td>
                                    <a href="?addressID=<?= $i ?>">
                                        <?= $i === $lastSearchID ? '<span class="bg-primary">' : '' ?>
                                        <?= $item->getAddress() ?>
                                        <?= $i++ === $lastSearchID ? '</span>' : '' ?>
                                    </a>
                                </td>
                                <td><?= sprintf("Широта: %'09f | Долгота: %'09f", $item->getLatitude(), $item->getLongitude()) ?></td>
                            </tr>
                        <?php
                        endforeach; ?>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6 col-xs-push-2">
                    <?php if (!empty($resultForMap)) : ?>
                        <script type="text/javascript">
                            ymaps.ready(init);
                            var myMap, myPlacemark;

                            function init() {
                                myMap = new ymaps.Map("map", {
                                    center: [<?= $resultForMap->getLatitude() ?>, <?= $resultForMap->getLongitude() ?>],
                                    zoom: 10
                                });
                                myPlacemark = new ymaps.Placemark([<?= $resultForMap->getLatitude() ?>, <?= $resultForMap->getLongitude() ?>], {
                                    hintContent: '<?= $resultForMap->getAddress() ?>',
                                    balloonContent: '<?= $resultForMap->getAddress() ?>'
                                });
                                myMap.geoObjects.add(myPlacemark);
                            }
                        </script>
                        <div id="map" style="width: 720px; height: 480px"></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <hr>
</div>
</body>
</html>