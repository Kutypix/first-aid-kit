<?php
    session_start();
    require_once "db_settings.php";
    $_SESSION['server_name'] = $server_name;
    $_SESSION['user_name'] = $user_name;
    $_SESSION['password'] = $password;
    $_SESSION['db_name'] = $db_name;

    $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'], 
            $_SESSION['password'], $_SESSION['db_name']);

    if(!$conn)
        die("Failed ". mysqli_connect_error());

    $user_login = $conn -> real_escape_string($_POST['login']);
    $user_password = $conn -> real_escape_string($_POST['haslo']);

    $sql = "SELECT * FROM `apteczka_users` WHERE `user_email`='$user_login' ";
    $res = $conn -> query($sql);
    
    if($res -> num_rows > 0){
        $record =  $res -> fetch_array(MYSQLI_ASSOC);
        $hash = $record["user_password_hash"];
        // password verification
        if(password_verify($user_password, $hash)){
            $_SESSION["current_user"] = $record["user_id"];
            header('Location: logged.php');
            exit;
        }
        else{
            header('Location: ../../index.html');
            exit;
        }
    }
    else{
        header('Location: ../../index.html');
        exit;
    }
    $conn -> close();
?>