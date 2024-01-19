<?php
    session_start();
    include "Objects_DB_Acess.php";
    $conn = new Objects_DB_Acess;

    

    $full_name = $_POST['full_name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if($password === $password_confirm){
        $password = md5($password);

        $query = "INSERT INTO `users` (`id`, `full_name`, `login`, `email`, `password`) VALUES (NULL, '$full_name', '$login', '$email', '$password') ";
        $conn->issue_query($query);
        
        $_SESSION['message'] = 'Регистрация прошла успешно';
        header('Location: authorization.php');
    } else{
        $_SESSION['message'] = 'Пароли не совпадат';
        header('Location: register.php');
    }
?>
