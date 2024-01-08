<?php
/*
include "db.php";

$sql = "SELECT JSON_UNQUOTE(JSON_EXTRACT(Items, '$[*].coordinates[*]')) AS coordinates
        FROM course
        WHERE JSON_CONTAINS(Items, '{\"type\": \"MultiPoint\"}')";

$result = $conn->query($sql);

$data = array(); 

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $coordinates = json_decode($row['coordinates'], true);

        $points = array();
        for ($i = 0; $i < count($coordinates); $i += 2) {
            $x = $coordinates[$i];
            $y = $coordinates[$i + 1];
            $points[] = array('type' => 'Feature', 'geometry' => array('type' => 'Point', 'coordinates' => array($x, $y)));
        }

        $data[] = array('type' => 'FeatureCollection', 'features' => $points);
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "0 результатов";
}
*/?>
