<?php
    session_start();

    $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'], 
            $_SESSION['password'], $_SESSION['db_name']);

    if(!$conn)
        die("Failed ". mysqli_connect_error());

    session_unset();
    session_destroy();
    if(isset($_SESSION["current_user"]))
        header('Location: logged.php');
    else
        header('Location: ../../index.html');
    $conn -> close();
?>