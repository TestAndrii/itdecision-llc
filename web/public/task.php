<?php

include '../app/src/db.php';
$task = 1; // id выбранного заказа
$done = 0; // флаг выполнения заказа

if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    // update info
    if(isset($_GET['task'])){
        $task = (int) $_GET['task'];
    }
    if(isset($_GET['done'])){
        $done = (int) $_GET['done'];
        $task = $done;
        // Отметка о выполнении заказа
        $strsql = 'update TODOLIST set `DONE` = 1 where `ID` = '.$task;
        if ($result = $mysqli->query($strsql)) {
            printf("<b>(Измен статус %d заказов.)</b>\n", $result->num_rows);
        } else {
            echo "<b>Ошибка доступа к таблице заказов.  <a type='button' class='btn btn-success' href = init.php>Создать таблицу</a></b>";
        }
    }
}

// Выбираем заказ
$strsql = 'select * from TODOLIST where `ID` = '.$task;
if ($result = $mysqli->query($strsql)) {
    printf("<b>(Загружено %d заказов.)</b>\n", $result->num_rows);
} else {
    echo "<b>Ошибка доступа к таблице заказов.  <a type='button' class='btn btn-success' href = init.php>Создать таблицу</a></b>";
}
include_once '../app/src/head.html';
?>

<h1 class='text-center'>Информация о заказе</h1>
<table class="table table-bordered table-striped">
    <tbody>
        <tr>
        <th class="text-center">id</th>
        <th class="text-center">Категория</th>
        <th class="text-center">Дата, время</th>
        <th class="text-center">Заголовок</th>
        <th class="text-center">Описание</th>
        <th class='text-center'>Действие</th>
        </tr>

<?php

mysqli_data_seek($result, 0);
if ($result->num_rows == 0) { 
    echo '<td>Нет заказов!</td>';
}

while ($row = mysqli_fetch_row($result)) {
    echo "<tr>\n";
    for ($i = 0; $i < mysqli_num_fields($result); $i++) {
        if($i < 5){
            echo '<td>' . $row[$i] . '</td>';
        } else {
            if($row[5] < 1){
            echo "<td><a class='btn btn-success' href='task.php?done=".$row[0]."'>Выполнить</a></td>";
        } else {
            echo "<td>Выполнен</td>";
        }
        }
    }
    echo "</tr>\n";
}

$result->close();
mysqli_close($mysqli);
?>

</tbody>
</table>
