<?php 
    define('DB_HOST', 'localhost'); //Адрес
    define('DB_USER', 'irina_db'); //Имя пользователя
    define('DB_PASSWORD', 'ilpheza15'); //Пароль
    define('DB_NAME', 'irina_db'); //Имя БД
    $conn  = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
   // Проверка соединения
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }
?>
