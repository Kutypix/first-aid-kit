<?php
    session_start();
    if(!isset($_SESSION["current_user"])) 
            header('Location: ../../index.html');
    // jeśli nie wybrano żadnych leków to odsyła nas z powrotem do wyboru leków
    if(!isset($_POST['chose_drug']))
        header('Location: manage_drugs.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>...::: Kit managment :::...</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/manage_drugs.css">
    <link rel="stylesheet" href="../../css/template.css">
    <link rel="icon" type="imge/x-icon" href="../../img/favicon/drug_managment.png">
</head>
<body>
    <div class="head">
        <p>Selected drugs</p>
    </div>
    <form method="post" action="take_drug.php">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Number of tablets to take</th>
            </tr>
            <?php
                $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'],$_SESSION['password'], $_SESSION['db_name']);
                $id = @$_POST['current_user'];
                $_SESSION['drugs'] = $_POST['chose_drug'];
                foreach($_POST['chose_drug'] as $val){
                    $sql = "SELECT * FROM user_drugs WHERE id='$val'";
                    if($res = $conn -> query($sql)){
                        while($row = $res -> fetch_array(MYSQLI_ASSOC)){
                            echo"
                                <tr>
                                    <th>".$row['drug_id']."</th>
                                    <th>".$row['name']."</th>
                                    <th>".$row['descr']."</th>
                                    <th>
                                        <input style='width : 170px;' type='number' name='quantity[]' min=1 max=".$row['count']." placeholder='Available ".$row['count']." pcs.'>
                                    </th>
                                <tr>";
                        }
                    }
                }
                $conn -> close();
            ?>
        </table>
        <input class="bt" type="submit" value="Take">
    </form>    
    <a href="manage_drugs.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Return</p>
            </div>
        </div>
    </a>
</body>    
</html> 