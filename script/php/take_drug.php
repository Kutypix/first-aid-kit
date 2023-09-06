<?php
    session_start();
    if(!isset($_SESSION["current_user"])) 
            header('Location: ../../index.html');
    $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'],$_SESSION['password'], $_SESSION['db_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>...::: Zażywanie :::...</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/manage_drugs.css">
    <link rel="stylesheet" href="../../css/take_drug.css">
    <link rel="stylesheet" href="../../css/template.css">
    <link rel="icon" type="imge/x-icon" href="../../img/favicon/drug_managment.png">
</head>
<body>
    <div id="info">
    <?php
        for($i=0; $i<count($_POST['quantity']); $i++){
            $drug_id = $_SESSION['drugs'][$i];
            $user_id = $_SESSION['current_user'];
            $sql_insert = "INSERT INTO take_drug (user_id, drug_id, count, take_date) VALUES ('$user_id', '$drug_id', '".$_POST['quantity'][$i]."', '".date('Y-m-d')."')";
            $res_insert = $conn -> query($sql_insert);
            $sql = "SELECT count FROM user_drugs WHERE id='$drug_id'";
            if($res = $conn -> query($sql)){
                while($row = $res -> fetch_array(MYSQLI_ASSOC)){
                    $remain = $row['count'] - $_POST['quantity'][$i];
                    $sql_update = "UPDATE user_drugs SET count='$remain' WHERE id='$drug_id'";
                    $res_up = $conn -> query($sql_update);
                    $current_id = $_SESSION['drugs'][$i];
                    $sql_d_name = "SELECT name FROM user_drugs WHERE id='$current_id'";
                    $res_d_name = $conn -> query($sql_d_name);
                    $d_name = $res_d_name -> fetch_array(MYSQLI_ASSOC);
                    echo "<p> Taken: ".$_POST['quantity'][$i]." pcs. of : ".$d_name['name']."</p>";
                }
            }
        }
        if(isset($res))
            echo "<p class='msg'> Dosing history updated </p>";
    ?>
    </div>
    <a href="logged.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Maine Site</p>
            </div>
        </div>
    </a>
    <a href="manage_drugs.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Return</p>
            </div>
        </div>
    </a>
</body>    
</html> 