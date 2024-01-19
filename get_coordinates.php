<?php
ini_set('memory_limit', '256M');
include "Objects_DB_Acess.php";
$conn = new Objects_DB_Acess;


$data = array(); 

$query = "SELECT 
JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[0]')) AS x, 
JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[1]')) AS y,
`Объект` AS name,
`Полный адрес` AS adress
FROM course
WHERE JSON_CONTAINS(`На карте`, '{\"type\": \"Point\"}')";

$conn->issue_query($query);

while ($row = $conn->fetch_array()) {
    $data[] = array(
        'type' => 'Feature',
        'geometry' => array('type' => 'Point', 'coordinates' => [$row['y'], $row['x']]),
        'properties' => array(
            'name' => $row['name'],
            'balloonContentHeader' => $row['name'], 
            'balloonContentBody' => 'Адрес: ' . $row['adress'],
        )
    );
}

header('Content-Type: application/json');
echo json_encode(array('type' => 'FeatureCollection', 'features' => $data));
?>
