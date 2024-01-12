// process_form.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processed Form Data</title>
</head>
<body>
    <h2>Данные из формы:</h2>

    <?php
    // Получение данных из массива $_POST
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
    $radius = isset($_POST['radius']) ? $_POST['radius'] : '';

    // Вывод данных
    echo "<p>Широта: $latitude</p>";
    echo "<p>Долгота: $longitude</p>";
    echo "<p>Радиус: $radius</p>";
    ?>
</body>
</html>
