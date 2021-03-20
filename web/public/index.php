<?php

include '../app/src/db.php';

// Данные по умолчанию)
$done = 0; // Показывать только не выполненные
$load = 0; // Флаг загрузки новых заказов.
$filename = '/var/www/html/todo.txt'; // Файл для загрузки заказов

// Обработка входных параметров - маршруты
if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    // update info
    if(isset($_GET['user'])){
        $done = (int) $_GET['user'];
    }
    if(isset($_GET['load'])){
        $load = (int) $_GET['load'];
    }
}
// Выбираем нужные заказы 
// ( все для администратора и не выполненные для пользователя)
$strsql = ($done > 0) ? 
    'select * from TODOLIST' :
    'select * from TODOLIST where DONE = 0';
    
if ($result = $mysqli->query($strsql)) {
    printf("<b>(Загружено %d заказов.)</b>\n", $result->num_rows);
} else {
    echo "<b>Ошибка доступа к таблице заказов.  <a type='button' class='btn btn-success' href = init.php>Создать таблицу</a></b>";
}

include_once '../app/src/head.html';
?>


    <?php
    if($load) {
        include_once('load.php');
    } else {
    ?>        
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                <th class="text-center">Категория</th>
                <th class="text-center">Заголовок</th>
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
                        if(in_array($i,[1,3])){
                            echo '<td>' . $row[$i] . '</td>';
                        }
                    }

                    echo "<td><a class='btn btn-success' href='task.php?task=".$row[0]."'>Подробнее</a></td>";
                    echo "</tr>\n";
                }

                $result->close();
                mysqli_close($mysqli);
                ?>

            </tbody>
        </table>
<?php
    }
?>

    </div>
</body>

</html>