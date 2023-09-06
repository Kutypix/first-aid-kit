<!DOCTYPE html>
<html lang="en">
<head>
    <title>...::: Registration :::...</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/logged_user.css">
    <link rel="stylesheet" href="../../css/register.css">
    <link rel="stylesheet" href="../../css/template.css">
    <link rel="icon" type="imge/x-icon" href="../../img/favicon/register.png">
</head>
<?php

    require_once "db_settings.php";
    $conn = new mysqli($server_name, $user_name, $password, $db_name);

    if(!$conn)
        die("Failed ". mysqli_connect_error());

    $us_name = $conn -> real_escape_string($_POST["reg_name"]);
    $us_surname = $conn -> real_escape_string($_POST["reg_surname"]);
    $us_email = $conn -> real_escape_string($_POST["reg_email"]);
    $us_bday = $_POST["reg_bday"];
    $us_password = $conn -> real_escape_string($_POST["reg_pass"]);
    
    $us_password_hashed = password_hash($us_password, PASSWORD_DEFAULT);

    // usser add query
    $sql = "INSERT INTO apteczka_users (user_name, user_surname, user_email, user_password_hash, user_bday) 
            VALUES ('$us_name','$us_surname','$us_email','$us_password_hashed','$us_bday')";

    // does e-mail exist ?
    $sql2 = "SELECT * FROM apteczka_users WHERE user_email='$us_email'";
    $res = $conn -> query($sql2);

    // if true then error, if not user added
?>
<body>
    <div id="head">
        <p id="title">Registration</p>
    </div>
    <div id="cont">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <fieldset>
                <legend>Please fill in the necessary data</legend><br>
                <label for id="name">Name :</label>
                <input id="name" class="inp" type="text" name="reg_name" placeholder="Donald" required><br><br>
                <label for id="surname">Surname :</label>
                <input id="surname" class="inp" type="text" name="reg_surname" placeholder="Trump" required><br><br>
                <label for id="e_mail">E-mail :</label>
                <input id="e_mail" class="inp" type="email" name="reg_email" placeholder="dtrump.gmail.com" required><br><br>
                <label for id="bday">Date of birth :</label>
                <?php echo"<input id='bday' class='inp' type='date' name='reg_bday' min='1900-01-01' max='".date("Y-m-d")."' required><br><br>"?>
                <label for id="pass">Password :</label>
                <input id="pass" class="inp" type="password" name="reg_pass" placeholder="password" required><br><br>
                <?php
                if($us_name && $us_surname && $us_email && $us_bday && $us_password){
                    if($res -> num_rows > 0) 
                        echo "<p class='alert2'> Provided e-mail is already occupied.</p>";
                    else{
                        if($conn -> query($sql) == TRUE)
                            echo "<p class='alert1'> The user has been registered.</p>";
                        else if($conn -> connect_error)
                            echo "<p class='alert2'> Something went wrong :c.</p>";
                        else{} 
                    }   
                }
                ?>
                <input class="bt" type="reset" value="Clear">
                <input class="bt" type="submit" value="Confirm">
            </fieldset>
        </form><br>
        <a href="../../index.html">
            <div style="margin: auto; width: 162px;"><div id="back">
                <p style="margin: auto;">Return</p>
            </div></div>
        </a>
    </div>
</body>
</html>