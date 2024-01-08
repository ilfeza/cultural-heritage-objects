<?php 
    define('DB_HOST', 'localhost'); //Адрес
    define('DB_USER', 'root'); //Имя пользователя
    define('DB_PASSWORD', ''); //Пароль
    define('DB_NAME', 'course'); //Имя БД
    $conn  = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
   // Проверка соединения
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }
?>
