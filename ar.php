<?php
include "db.php";
 
    // Запрос к базе данных
$sql = "SELECT JSON_UNQUOTE(JSON_EXTRACT(Items, '$[*].coordinates[0]')) AS x, 
JSON_UNQUOTE(JSON_EXTRACT(Items, '$[*].coordinates[1]')) AS y
FROM course
WHERE JSON_CONTAINS(Items, '{\"type\": \"Point\"}')";

$result = $conn->query($sql);


// ... (ваш предыдущий код для подключения к базе данных и выполнения запроса)


// ... (ваш предыдущий код для подключения к базе данных и выполнения запроса)

$data = array(); // Создаем массив для хранения данных

if ($result->num_rows > 0) {
    // Получение данных из результата запроса
    while ($row = $result->fetch_assoc()) {
        $xArray = json_decode($row['x'], true); // Добавляем параметр true для преобразования в ассоциативный массив
        $yArray = json_decode($row['y'], true);

        foreach ($xArray as $key => $x) {
            $y = $yArray[$key]; // Получаем соответствующее значение y
            $data[] = array('x' => $x, 'y' => $y); // Добавляем значения x и y в массив данных
        }
    }

    // Закрытие соединения с базой данных
    $conn->close();
} else {
    echo "0 результатов";
}

// Генерация JavaScript-кода для передачи данных в script.js
echo '<script>';
echo 'let points = ' . json_encode($data) . ';'; // Передача массива точек в JavaScript
echo '</script>';
?>
