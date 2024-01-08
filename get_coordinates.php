<?php
include "db.php";

$data = array(); // Массив для хранения данных

try {
    $sql = "SELECT JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[0]')) AS x, 
                   JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[1]')) AS y
            FROM course
            WHERE JSON_CONTAINS(`На карте`, '{\"type\": \"Point\"}')";

    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = array('type' => 'Feature', 'geometry' => array('type' => 'Point', 'coordinates' => [$row['y'], $row['x']]));
        }
        $result->free_result();
    } else {
        throw new Exception("Ошибка выполнения запроса: " . $conn->error);
    }

    $conn->close();

    // Возвращаем данные в формате JSON
    header('Content-Type: application/json');
    echo json_encode(array('type' => 'FeatureCollection', 'features' => $data));
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
