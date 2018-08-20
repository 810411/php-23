<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Строки, массивы и объекты</title>
        <meta name="description" content="Нетология. Курс PHP/SQL. Урок 1.3">
    </head>
    <body>
        <?php
            $continentsAndAnimals = array(
                "Europe" => array ("Odobenus rosmarus", "Ursus arctos", "Cervus elaphus", "Canis lupus"),
                "Asia" => array ("Elephas maximus", "Panthera tigris", "Myopus"),
                "Africa" => array("Acinonyx jubatus", "Hyaena", "Monachus", "Testus foo bar"),
                "Australia" => array("Ornithorhynchus anatinus", "Macropus rufus", "Sarcophilus harrisii")
            );
            $animals = array();
            $fantasyAnimals = array();
            $firstName = array();
            $secondName = array();
            $index = 0;

            echo "<pre>";
            echo "<h3>Source array:</h3>";
            print_r($continentsAndAnimals);

            foreach ($continentsAndAnimals as $continent => $animal){
                foreach ($animal as $a){
                    if (str_word_count($a, 0) === 2){
                        $animals[] = $a;
                        $explodeFromAnimal = explode(" ", $a);
                        $firstName[$continent][] = $explodeFromAnimal[0];
                        $secondName[] = $explodeFromAnimal[1];
                    }
                }
            }

            echo "<h3>Source array with two-words names only:</h3>";
            print_r($animals);
            echo "<h3>Result array - fantasy animals:</h3>";

            shuffle($secondName);

            foreach ($firstName as $continent => $animal){
                for ($i = 0; $i < count($animal); $i++){
                    $fantasyAnimals[] = $firstName[$continent][$i] = $animal[$i] . ' ' . $secondName[$index++];
                }
            }

            print_r($fantasyAnimals);
            echo "<h3>Extra:</h3>";

            foreach ($firstName as $continent => $animal){
                echo "<h2>$continent</h2>";
                echo '<p>' . implode (', ', $animal) . '</p>';
            }
        ?>
    </body>
</html>