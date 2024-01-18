<?php

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
 
    $earthRadius = 6371;


    $lat1 = deg2rad($lat1);
    $lon1 = deg2rad($lon1);
    $lat2 = deg2rad($lat2);
    $lon2 = deg2rad($lon2);


    $latDiff = $lat2 - $lat1;
    $lonDiff = $lon2 - $lon1;

    $a = sin($latDiff / 2) * sin($latDiff / 2) + cos($lat1) * cos($lat2) * sin($lonDiff / 2) * sin($lonDiff / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));


    $distance = $earthRadius * $c;

    return $distance;
}


$latitude1 = 40.7128;
$longitude1 = -74.0060; 

$latitude2 = 34.0522; 
$longitude2 = -118.2437; 

$distance = calculateDistance($latitude1, $longitude1, $latitude2, $longitude2);

echo "Расстояние между точками: " . round($distance, 2) . " км";

?>
