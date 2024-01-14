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
	<link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <title>Hello, world!</title>
	<style>
		
		.ymaps-b-balloon {
			border-radius: 10px;
			background-color: #ffffff; 
			color: #000000;
			padding: 10px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); 
		}

		
		.ymaps-b-balloon__tail {
			display: none; 
		}

	</style>
</head>
<body>
	<!-- Меню -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">
				<img src="images/museum.svg" alt="Логотип" style="width: 50px; height: auto;">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="#">Главная</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">О нас</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Услуги</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="map.html">Карта</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div id="map-test" class="map"></div>
	<button id="getCoordinatesBtn">Узнать координаты</button>
	<form action="inradius.php" method="post">
		<label for="latitudeInput">Широта:</label>
		<input type="text" id="latitudeInput" name="latitude">
		<br>
		<label for="longitudeInput">Долгота:</label>
		<input type="text" id="longitudeInput" name="longitude">
	
		<label for="radiusInput">Радиус:</label>
		<input type="text" id="radiusInput" name="radius">
		<button id="radiusOnMap">Показать на карте</button>
		<button type="submit">отправить</button>
	</form>


	

	<div class="custom-footer text-white text-center text-lg-start">
		<footer class="bg-body-tertiary text-center">
			
			<div class="text-center p-2">
				© 2020 Copyright:
				<a class="text-body" href="https://mdbootstrap.com/">MDBootstrap.com</a>
			</div>
		</footer>
	</div>
	

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<script src="https://api-maps.yandex.ru/2.1/?apikey=ваш API-ключ&lang=ru_RU">
	</script>
	<script src="script.js"></script>
</body>
</html>