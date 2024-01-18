<?php 
include "Objects_DB_Acess.php";
$conn = new Objects_DB_Acess;


$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';
$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';
$radius = isset($_POST['radius']) ? $_POST['radius'] : '';


?>

<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/main.css">
	<link rel="stylesheet" href="styles/palette.scss">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .data-container {
        display: flex;
        align-items: flex-start; 
        margin: 20px;
    }

    .map-container {
        flex: 7;
        margin-right: 20px;
        height: 100%; 
    }

    .map {
        width: 100%;
        height: 500px; 
        background-color: #333;
    }

    .info-container {
        flex: 3;
    }

    .info-container p {
        font-size: small;
    }

    .info-container strong {
        font-weight: bold;
    }
</style>

    <title>Hello, world!</title>
</head>
<body>
	<!-- Меню -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="index.php">
				<img src="images/museum.svg" alt="Логотип" style="width: 50px; height: auto;">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Главная</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="authorization.php">Авторизация</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="profile.php">Профиль</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link" href="search.php">Поиск</a>
					</li>
                    <li class="nav-item">
						<a class="nav-link" href="map.php">Карта</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
    <div class="data-php" data-attr="<?=$latitude; ?>" data-attr2="<?=$longitude; ?>" data-attr3="<?=$radius; ?>"></div>

    

    <div class="data-container">
        <div class="map-container">
            <div id="map-test" class="map"></div>
        </div>
        <div class="info-container">
            <?php
            $query = "SELECT 
            JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[0]')) AS x, 
            JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[1]')) AS y,
            `Объект` AS name,
            `Полный адрес` AS adress
            FROM course
            WHERE JSON_CONTAINS(`На карте`, '{\"type\": \"Point\"}') AND 
            HaversineDistance($latitude, $longitude, JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[1]')), JSON_UNQUOTE(JSON_EXTRACT(`На карте`, '$.coordinates[0]'))) <= $radius";

            $conn->issue_query($query);

            if ($conn->num_rows > 0) {
 
                while($row = $conn->fetch_array()) {
                    echo "<p><strong>Название объекта:</strong> " . $row["name"] . "</p>";
                    echo "<p>Адрес:</strong> " . $row["adress"] . "</p>";
                }
            } else {
                echo "<p>Нет данных, удовлетворяющих условиям.</p>";
            }
            ?>
        </div>
    </div>

    <div class="custom-footer text-white text-center text-lg-start">
        <footer class="bg-body-tertiary text-center">
            <div class="text-center p-2">
                © 2020 Copyright:
                <a class="text-body" href="https://mdbootstrap.com/">MDBootstrap.com</a>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=ваш API-ключ&lang=ru_RU"></script>
 
    <script src="radiusonmapScript.js" defer></script>

</body>
</html>
