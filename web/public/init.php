<?php
include '../app/src/db.php';
include_once '../app/src/head.html';
$filename = '/var/www/html/todo.txt'; // Файл для загрузки заказов

echo '<hr><h1 class="text-center">Создаём БД</h1>';

$sqlTable = "DROP TABLE IF EXISTS TODOLIST";
if ($mysqli->query($sqlTable)) {
    echo "Table dropped successfully! <br>";
} else {
    echo "Cannot drop table. "  . mysqli_error($mysqli);
}


echo "Executing CREATE TABLE TODOLIST Query...<br>";
$sqlTable = "
CREATE TABLE `TODOLIST` (
    `ID` bigint NOT NULL AUTO_INCREMENT,
    `CAT_NAME` varchar(255) DEFAULT NULL,
    `TIME_ADD` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `TITLE` varchar(255) DEFAULT NULL,
    `DESCRIPTION` varchar(255) DEFAULT NULL,
    `DONE` int DEFAULT 0,
    PRIMARY KEY (ID),
    UNIQUE (`CAT_NAME`,`TIME_ADD`,`TITLE`,`DESCRIPTION`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

if ($mysqli->query($sqlTable)) {
    echo "Table created successfully!<br>";
} else {
    echo "ERROR: Cannot create table. "  . mysqli_error($mysqli);
    // die();
}

echo "Executing INSERT INTO TODOLIST Query...<br>";
$sqlTable = "
INSERT INTO `TODOLIST` (`ID`, `CAT_NAME`, `TIME_ADD`, `TITLE`, `DESCRIPTION`) VALUES (NULL, 'supply', CURRENT_TIMESTAMP, 'Заказать воду', 'В диспенсере заканчивается вода, нужно заказать в компании Bluewater 2 бутыля')";

if ($mysqli->query($sqlTable)) {
    echo "Data insert successfully!<br>";
} else {
    echo "ERROR: Cannot insert table. "  . mysqli_error($mysqli);
    // die();
}

?>

<h1 class="text-center">Создаём TXT файл</h1>
<?php

// Открываем файл для записи
$handler = fopen($filename, "w+");

for( $i=1; $i<100; $i++){
    // Заполнение данными для загрузки
    $date = date('Y-m-d\TH:i:sP',time() + rand(0,100));
    $text = (string) "supply ".$date." Заказать воду; В диспенсере заканчивается вода, нужно заказать в компании Bluewater 2 бутыля\n";
    fwrite($handler, $text);
}
fclose($handler);
?>

<p>Созданны данные для загрузки в БД</p>
