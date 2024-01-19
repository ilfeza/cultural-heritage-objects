<?php
    session_start();
    include "Objects_DB_Acess.php";
    $conn = new Objects_DB_Acess;
  
    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $query = "SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password' ";
    $conn->issue_query($query);
    if($conn->num_rows > 0){
        $user = $conn->fetch_array();
   

        $_SESSION['user'] = [
            "id" => $user['id'],
            "full_name" => $user['full_name'],
            "email" => $user['email']
        ];

        header('Location: profile.php');
    }
    else{
        $_SESSION['message'] = 'Не верный логин или пароль';
        header('Location: authorization.php');
    }
?>
