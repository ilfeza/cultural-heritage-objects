<?php
session_start();
include('config.php');
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
		.text-link {
			background: none;
			border: none;
			color: #888; 
			text-decoration: none;
			cursor: pointer;
			margin: 0; 
			padding: 0; 
		}
		.map {
			width: 100%;
			height: 80vh;
			margin: 5vh auto;
			background-color: #333;
			padding-right: 0;
		}
		h1 {
			font-weight: bold;
			margin-bottom: 2rem;
		}


		

	</style>
	<title>Объекты культуры</title>
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
	
	
	<div class="container mt-4">
	<h4 class="fw-bold mb-4">На этой карте вы можете ознакомиться с различными культурными объектами и также найти интересующие вас места в заданном радиусе</h4>
		<div class="row mb-3">
			<div class="col-md-6">
				<button id="getCoordinatesBtn" class="text-link" onclick="getCoordinates()">Узнать координаты</button>
				<form action="inradius.php" method="post" onsubmit="return validateForm()">
					<div class="row mb-3">
						<div class="col-md-12">
							<label for="latitudeInput" class="form-label">Широта:</label>
							<input type="text" id="latitudeInput" name="latitude" class="form-control" placeholder="Введите широту" required>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12">
							<label for="longitudeInput" class="form-label">Долгота:</label>
							<input type="text" id="longitudeInput" name="longitude" class="form-control" placeholder="Введите долготу" required>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12">
							<label for="radiusInput" class="form-label">Радиус:</label>
							<input type="text" id="radiusInput" name="radius" class="form-control" placeholder="Введите радиус" required>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12">
							<button id="radiusOnMap" class="text-link" onclick="saveCoordinates()">Показать на карте</button>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-12">
							<button type="submit" class="btn btn-sm btn-danger mt-2">Отправить</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<div id="map-test" class="map"></div>
			</div>
		</div>
	</div>


	

	<div class="custom-footer text-center text-lg-start">
        <footer class="bg-body-tertiary text-white text-center">
            <div class="text-center p-2">
                <a href="https://opendata.mkrf.ru/opendata/7705851331-egrkn" class="text-white">Сайт разработан на основе открытых данных</a>
                <br/><a href="mailto:ilffezaaa@gmail.com" class="text-white">По всем вопросам обращайтесь на почту: ilffezaaa@gmail.com</a>
            </div>
        </footer>
    </div>
	

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<?php echo $apiKey; ?>"></script>
	<script>
		
		function saveCoordinates() {
			var latitude = parseFloat(document.getElementById("latitudeInput").value);
			var longitude = parseFloat(document.getElementById("longitudeInput").value);
			var radius = parseFloat(document.getElementById("radiusInput").value);

			localStorage.setItem("latitude", latitude);
			localStorage.setItem("longitude", longitude);
			localStorage.setItem("radius", radius);
			console.log(latitude, longitude, radius);
		}

		function validateForm() {
			var latitude = document.getElementById('latitudeInput').value;
			var longitude = document.getElementById('longitudeInput').value;
			var radius = document.getElementById('radiusInput').value;

			if (latitude.trim() === '' || longitude.trim() === '' || radius.trim() === '') {
				alert('Пожалуйста, заполните все поля.');
				return false;
			}

		

			return true;
		}

	
	</script>
	<script src="script.js"></script>
		
</body>
</html>
