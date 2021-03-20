<h1>ЗАГРУЗКА ЗАКАЗОВ в БД</h1>
<?php
// Открываем файл для чтения
$handle = fopen($filename, "r");

if($handle){
    while(($buffer = fgets($handle, filesize($filename))) !== false){
        // echo $buffer;

        preg_match("/^(\S+)\s(\S+)\s(\D+);(.+)/",$buffer,$params);
        $cat_name = trim($params[1]);
        $timestamp = date('Y-m-d H:i:s',strtotime($params[2]));
        $title = trim($params[3]);
        $description = trim($params[4]);

        $sqlTable = "
        INSERT INTO `TODOLIST` 
        (`ID`, `CAT_NAME`, `TIME_ADD`, `TITLE`, `DESCRIPTION`) VALUES 
        (NULL, '$cat_name','$timestamp','$title','$description')";
        
        if ($mysqli->query($sqlTable)) {
            echo "Заказ добавлен! <br>";
        } else {
            echo "<div class='text-danger'>Дубликат не загружен: "  . mysqli_error($mysqli) ."</div>";
        }

    }
    if (!feof($handle)) {
        echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
    }
    fclose($handle);
}

?>
