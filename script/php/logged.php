<?php
    session_start();
    if(!isset($_SESSION["current_user"])) 
        header('Location: ../../index.html');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>...::: First Aid Kit :::...</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/logged_user.css">
    <link rel="stylesheet" href="../../css/template.css">
    <link rel="icon" type="imge/x-icon" href="../../img/favicon/pharmacy.png">
</head>
<body>
    <?php
        $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'],$_SESSION['password'], $_SESSION['db_name']);

        if(!$conn)
            die("Failed ". mysqli_connect_error());
        // jeżeli nie jest zalogowany to żeby nie wyświetlać pustej strony bez niczego
        // przekierowywani jesteśmy do strony logowania, w przeciwnym razie mamy dostęp
        $id = $_SESSION['current_user'];
        $sql = "SELECT * FROM `apteczka_users` WHERE `user_id`= $id ";
        $res = $conn -> query($sql);
    
        if($res -> num_rows > 0)
            $record =  $res -> fetch_array(MYSQLI_ASSOC);
    ?>
    <div id="head">
        <p id="title">
            <?php
                echo "Hello ".$record["user_name"]." ".$record["user_surname"];
            ?>
        </p>
    </div>
    <div id="profile">
        <?php
        // zdjęcia profilowe
            $sql = "SELECT `user_img` FROM `apteczka_users` WHERE `user_id`='$id'";
            $res = $conn -> query($sql);
            $record =  $res -> fetch_array(MYSQLI_ASSOC);
            echo '<img src="../../img/'.$record["user_img"].'" width="150" height="150">';
        ?>
    </div>
    <div id='fieldset'>
        <fieldset>
            <legend>Profile photo</legend>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                <input type="file" name="uploadfile"><br><br>
                <input id="up_bt" type="submit" name="upload" value="Upload"><br>
            </form>
            <?php
            // jeśli załadowano obraz
            if(isset($_POST["upload"])){
                $filename = $_FILES["uploadfile"]["name"];
                $tempname = $_FILES["uploadfile"]["tmp_name"];
                $allowTypes = array('jpg','png','jpeg','gif');
                $folder = "../../img/".$filename;
                $fileType = pathinfo($folder,PATHINFO_EXTENSION);
                if($filename!='' && in_array($fileType, $allowTypes)){
                    $sql = "UPDATE `apteczka_users` SET `user_img`='$filename' WHERE `user_id`=$id";
                    $res = $conn -> query($sql);
                    move_uploaded_file($tempname, $folder);
                    header('Location: logged.php');
                }
                // błąd
                else
                    echo "<p style='text-align: center; color: rgb(187, 23, 23);'> Błąd podczas dodawnai obrazu</p>";
            }
            ?>
        </fieldset>
    </div>
    <?php
        $sql_is_admin = "SELECT is_admin FROM apteczka_users WHERE user_id=$id";
        $res_admin = $conn -> query($sql_is_admin);
        $row = $res_admin -> fetch_assoc();
        $_SESSION['is_admin'] = $row["is_admin"];
        if($_SESSION['is_admin']==1) {
            echo"
            <a href='add_drug.php'>
                <div class='outer_bt'>
                    <div class='bt'>
                        <p style='margin: auto;'>Add drugs to the DB</p>
                    </div>
                </div>
            </a>";
        }
        $conn -> close();
    ?>
    <a href="order_drugs.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Order drugs</p>
            </div>
        </div>
    </a>
    <a href="manage_drugs.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Kit management</p>
            </div>
        </div>
    </a>
    <a href="log_out.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Log out</p>
            </div>
        </div>
    </a>
</body>    
</html>