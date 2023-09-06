<!DOCTYPE html>
<html lang="en">
<head>
    <title>...::: Dodawanie użytkownika :::...</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/add_user.css">
    <link rel="icon" type="imge/x-icon" href="../../img/favicon/add_user.png">
</head>
<body>
<?php

    $server_name = "mysql.agh.edu.pl";
    $user_name = "mkutypa";
    $password = "68Hj9AXW7vj0gY5m";
    $db_name = "mkutypa";

    $conn = new mysqli($server_name, $user_name, $password, $db_name);

    // sprawdzenie połączenia z bazą danych
    if(!$conn)
        die("Failed ". mysqli_connect_error());

    // inicjalizacja zmiennych lokalnych z tablicy post 
    // real_escape_string zamienia znaki specjalne w łańcuchu zapytania SQL
    // bez tego niektóre zapytania ze znakami specjalnymi mogą się nie wykonać
    $us_name = $conn -> real_escape_string($_POST["reg_name"]);
    $us_surname = $conn -> real_escape_string($_POST["reg_surname"]);
    $us_email = $conn -> real_escape_string($_POST["reg_email"]);
    $us_bday = $_POST["reg_bday"];
    $us_password = $conn -> real_escape_string($_POST["reg_pass"]);

    // krzaczkowanie hasła - w bazie będą krzczki a nie hasło które user wpisał
    $us_password_hashed = password_hash($us_password, PASSWORD_DEFAULT);

    // zapytanie o dodanie użytkownika do bazy danych
    $sql = "INSERT INTO apteczka_users (user_name, user_surname, user_email, user_password_hash, user_bday) 
            VALUES ('$us_name','$us_surname','$us_email','$us_password_hashed','$us_bday')";

    // zapytanie sprawdzające czy istnieje już podany adress email
    $sql2 = "SELECT * FROM apteczka_users WHERE user_email='$us_email'";
    $res = $conn -> query($sql2);

    // jeżeli istnieje jakikolwiek rekord w tabeli z podanym 
    // e-mailem to po prostu informuje o błędzie i nie wykonujemy dodaia
    // a jeżeli nie ma (pusta ilość wierszy) to jest wolny i można dodać
    if($res -> num_rows > 0) 
        echo "
            <div class='info'> <br>Błąd! <br> Podany adres e-mail już jest zajęty.<br><br>
                <a href='register.php'>
                    <div style='margin: auto; width: 162px;'>
                        <div id='back'>
                            <p style='margin: auto;'>Powrót</p>
                        </div>
                    </div>
                </a>
            </div>";
    else{
        if($conn -> query($sql) == TRUE)
            echo "
            <div class='info'> <br>Użytkownik został zarejestrowany.<br><br>
                <a href='../../index.html'>
                    <div style='margin: auto; width: 162px;'>
                        <div id='back'>
                            <p style='margin: auto;'>Powrót</p>
                        </div>
                    </div>
                </a>
            </div>";
        else
            echo "
            <div class='info'> <br>Błąd! <br> Coś poszło nie tak.<br><br>
                <a href='register.php'>
                    <div style='margin: auto; width: 162px;'>
                        <div id='back'>
                            <p style='margin: auto;'>Powrót</p>
                        </div>
                    </div>
                </a>
            </div>";
    }   
    $conn -> close();
?>
</body>
</html>