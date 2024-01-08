<?php
include "db.php";

$sql = "SELECT Items FROM course WHERE JSON_CONTAINS(Items, '{\"type\": \"Point\"}') OR JSON_CONTAINS(Items, '{\"type\": \"MultiPoint\"}')";

$result = $conn->query($sql);

$data = array(); 

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items = json_decode($row['Items'], true);

        foreach ($items as $item) {
            if ($item['type'] === 'Point') {
                $coordinates = $item['coordinates'];
                $data[] = array('type' => 'Feature', 'geometry' => array('type' => 'Point', 'coordinates' => $coordinates));
            } elseif ($item['type'] === 'MultiPoint') {
                $multiCoordinates = $item['coordinates'];
                foreach ($multiCoordinates as $coords) {
                    $data[] = array('type' => 'Feature', 'geometry' => array('type' => 'Point', 'coordinates' => $coords));
                }
            }
        }
    }
    $conn->close();

    
    header('Content-Type: application/json');
    echo json_encode(array('type' => 'FeatureCollection', 'features' => $data));
} else {
    echo "0 результатов";
}
?>
