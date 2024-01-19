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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <title>Объекты культуры</title>
	<style>
	

.search-results.active {
  opacity: 1;
  pointer-events: auto;
}

.search-results .search-input {
  width: 100%;
  border: none;
  padding: 12px 16px;
  font-size: 16px;
  outline: none;
  box-sizing: border-box;
}

.search-results .search-title {
  font-size: 14px;
  margin: 16px 0;
}

.search-results ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.search-results ul a {
  text-decoration: none;
  font-size: 16px;
  color: #2b2d42;
  font-weight: bold;
  padding: 12px;
  display: inline-block;
  width: 100%;
  box-sizing: border-box;
  transition: all 400ms ease;
}

.search-results ul a:hover {
  background: #dae7eb;
}
.btn-primary {
    background-color: #a61c3cff;
    border-color: #a61c3cff;
}
.form-control:focus {
    border-color: #a61c3cff;
    box-shadow: 0 0 0 0.25rem rgba(166, 28, 60, 0.25);
}
	</style>
	
	
	
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

	<main class="container mt-4">
		<h4 class="fw-bold mb-4">Здесь вы можете произвести поиск по всем объектам культурного наследия</h4>
		<div class="search-results">
			<form class="d-flex" onsubmit="return false;"> 
			<div class="me-2 w-100">
				<label for="search" class="visually-hidden">Search:</label>
				<input type="text" class="form-control form-control-lg rounded-pill" id="search" name="search" oninput="liveSearch(event)">
			</div>
			<button type="button" class="btn btn-lg btn-primary rounded-pill mt-2" onclick="performSearch()">Поиск</button> 
			</form>
			<div class="results-container">
				<ul>
					<li>
						<div id="search-results"></div>
					</li>
				</ul>
				
			</div>
			
		</div>
		
	</main>




	
	
	<div class="custom-footer text-center text-lg-start">
        <footer class="bg-body-tertiary text-white text-center">
            <div class="text-center p-2">
                <a href="https://opendata.mkrf.ru/opendata/7705851331-egrkn" class="text-white">Сайт разработан на основе открытых данных</a>
                <br/><a href="mailto:ilffezaaa@gmail.com" class="text-white">По всем вопросам обращайтесь на почту: ilffezaaa@gmail.com</a>
            </div>
        </footer>
    </div>
	

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script>
		function liveSearch(event) {
			event.preventDefault(); 

			var searchTerm = $('#search').val();

			$.ajax({
				type: 'POST',
				url: 'search_data.php',
				data: { search: searchTerm },
				success: function(response) {
					$('#search-results').html(response);
				}
			});
		}

    </script>
	<script>
		function performSearch() {
			
			console.log("Выполнение поиска...");
		}
	</script>
</body>
</html>
