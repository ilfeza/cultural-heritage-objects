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
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;
        }
        h2 {
            margin-left: 20px; /* Вы можете установить нужное значение отступа сверху */
        }
        .img-fluid {
            margin-bottom: 20px; /* Отступ снизу для изображения */
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
                <h3 style="display: inline-block; margin-left: 10px; color: white">
                    <a href="index.php" style="text-decoration: none; color: inherit;">Реестр культурного наследия России</a>
                </h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <a class="nav-link" href="map.php">Карта</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search.php">Поиск</a>
                    </li>
                    <?php
         
                    if(isset($_SESSION['user'])) {
     
                        echo '<li class="nav-item">
                                <a class="nav-link" href="profile.php">Профиль</a>
                              </li>';
                    } else {

                        echo '<li class="nav-item">
                                <a class="nav-link" href="authorization.php">Авторизация</a>
                              </li>';
                    }
                    ?>
                    
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
    <?php
    include "Objects_DB_Acess.php";
    $conn = new Objects_DB_Acess;
    

    if (isset($_GET['id'])) {
        $courseId = $_GET['id'];

        $query = "SELECT * FROM course WHERE `Номер в реестре` = $courseId";
        $conn->issue_query($query);

        if ($conn->num_rows > 0) {
            $row = $conn->fetch_array();

            echo '<h2>' . $row['Объект'] . '</h2>';

            // Полный адрес
            if (!empty($row['Полный адрес'])) {
                echo '<p>Полный адрес: ' . $row['Полный адрес'] . '</p>';
            }

            // Вид объекта
            if (!empty($row['Вид объекта'])) {
                echo '<p>Вид объекта: ' . $row['Вид объекта'] . '</p>';
            }


            // Дата создания
            if (!empty($row['Дата создания'])) {
                echo '<p>Дата создания: ' . $row['Дата создания'] . '</p>';
            }

            // Изображение
            if (!empty($row['Изображение'])) {
                $imageData = json_decode($row['Изображение'], true);
                echo '<div class="col-lg-6"><img src="' . $imageData['url'] . '" alt="' . $imageData['title'] . '" class="img-fluid"></div>';
            }
        } else {
            echo '<p>not found</p>';
        }
    }

    
    ?>
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
</body>
</html>
