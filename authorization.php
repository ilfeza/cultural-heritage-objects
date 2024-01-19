<!DOCTYPE html>
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

    <title>Объекты культуры</title>
</head>
<body>

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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="signin.php" method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" class="form-control" id="login" name="login" placeholder="Введите свой логин">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль">
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color: #9C2C46;">Войти</button>
                    <p class="mt-2">
                        У вас нет аккаунта? - <a href="register.php">зарегистрируйтесь</a>!
                    </p>
                    <?php
                        if(isset($_SESSION['message'])){
                            echo '<p class="msg">'. $_SESSION['message'].' </p>';
                        }
                        unset($_SESSION['message']);
                    ?>
                </form>
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
</body>
</html>
