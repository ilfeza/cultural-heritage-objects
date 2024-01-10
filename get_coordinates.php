<?php
ini_set('memory_limit', '256M');
include "db.php";

$data = array(); 

try {
    $sql = "SELECT 
    JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[0]')) AS x, 
    JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[1]')) AS y,
    `Объект` AS name,
    `Полный адрес` AS adress,
    `Изображение` AS img
    FROM course
    WHERE JSON_CONTAINS(`На карте`, '{\"type\": \"Point\"}') AND `Изображение` IS NOT NULL";

    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $imageData = $row['img'] ? json_decode($row['img'], true) : null; // Проверка на null перед декодированием
            $data[] = array(
                'type' => 'Feature',
                'geometry' => array('type' => 'Point', 'coordinates' => [$row['y'], $row['x']]),
                'properties' => array(
                    'name' => $row['name'],
                    'balloonContentHeader' => $row['name'], // Заголовок балуна
                    'balloonContentBody' => 'Адрес: ' . $row['adress'] . '<br><img src="' . $imageData['url'] . '" alt="' . $imageData['title'] . '"></div>', // Содержимое балуна
                    'img' => $imageData // Добавление информации об изображении в свойство 'img'
                )
                
            );
        }

        $result->free_result();
    } else {
        throw new Exception("Ошибка выполнения запроса: " . $conn->error);
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode(array('type' => 'FeatureCollection', 'features' => $data));
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}


?>
