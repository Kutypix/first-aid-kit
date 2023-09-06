<?php
    session_start();
    if(!isset($_SESSION["current_user"])) 
            header('Location: ../../index.html');
    $today = date("Y-m-d");
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
        <p>List of medications to take</p>
    </div>
    <form method="post" action="chose_drug.php">
        <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Cost</th>
                    <th>Opis</th>
                    <th>Date of purchase</th>
                    <th>Expiration date</th>
                    <th>Action</th>
                </tr>
                <?php
                    $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'],$_SESSION['password'], $_SESSION['db_name']);
                    $id = $_SESSION['current_user'];
                    $sql = "SELECT * FROM user_drugs WHERE user_id = $id";
                    if($res = $conn -> query($sql)){
                        while($row = $res -> fetch_array(MYSQLI_ASSOC)){
                            // warunek wyświetlający odpowiedni warianty w przypadku przeterminowania
                            if(($row['date_exp'] < date("Y-m-d")) && $row['count']>0)
                                echo "<tr style='text-decoration: line-through; color : rgb(187, 23, 23);'>";
                            else if($row['count']<=0)
                                echo "<tr style='color : gray;'>";
                            else
                                echo "<tr>";
                                echo "
                                    <th>".$row['drug_id']."</th>
                                    <th>".$row['name']."</th>
                                    <th>".$row['count']."</th>
                                    <th>".$row['cost']."</th>
                                    <th>".$row['descr']."</th>
                                    <th>".$row['purchase_date']."</th>
                                    <th>".$row['date_exp']."</th>";
                            if($row['date_exp'] < date("Y-m-d") || $row['count']<=0)
                                echo "<th> X </th>";
                            else
                                echo "<th>
                                        <input type='checkbox' name='chose_drug[]' value='".$row['id']."'>
                                      </th>";
                                echo "</tr>";
                            }
                    }
                ?>
            </table>
        <?php 
            $sum = "SELECT ROUND(SUM(cost),2) AS total_cost FROM user_drugs WHERE user_id = $id";
            $res_sum = $conn -> query($sum);
            $row_sum = $res_sum -> fetch_array(MYSQLI_ASSOC);
            $total = $row_sum['total_cost'];
            echo "<p style='font-size: 20px; text-align:center;'> Total cost of drugs : ".$total.".</p>";
            $out_of_date = "SELECT COUNT(*) AS count_util FROM user_drugs WHERE user_id = $id AND date_exp < '$today'";
            $res_out = $conn -> query($out_of_date);
            $row_out = $res_out -> fetch_array(MYSQLI_ASSOC);
            $util = $row_out['count_util'];
            echo "<p style='font-size: 20px; text-align:center; color : rgb(187, 23, 23);'> Number of drugs to be disposed of : ".$util."</p>";

        ?>
        <input class="bt" type="submit" name="go_to_take_drug" value="Choose drugs">
    </form>
        <div class="head">
            <p>Dosing history</p>
        </div>
        <table>
            <tr>
                <th>Take ID</th>
                <?php
                    if($_SESSION['is_admin'])
                        echo "<th>User</th>";
                ?>
                <th>Drug</th>
                <th>Quantity</th>
                <th>Take date</th>
                <?php
                    if($_SESSION['is_admin'])
                        echo "<th>Picture</th>";
                ?>
            </tr>
            <?php
                if($_SESSION['is_admin']){
                    $sql_rel = "SELECT take_drug.take_id, apteczka_users.user_img, apteczka_users.user_name, apteczka_users.user_surname, 
                                user_drugs.name, take_drug.count, take_drug.take_date FROM ((take_drug 
                                INNER JOIN apteczka_users ON take_drug.user_id = apteczka_users.user_id) 
                                INNER JOIN user_drugs ON take_drug.drug_id = user_drugs.id) ORDER BY take_drug.take_id";
                }
                else{
                    $sql_rel = "SELECT take_drug.take_id, apteczka_users.user_img, apteczka_users.user_name, apteczka_users.user_surname, 
                                user_drugs.name, take_drug.count, take_drug.take_date FROM ((take_drug 
                                INNER JOIN apteczka_users ON take_drug.user_id = apteczka_users.user_id) 
                                INNER JOIN user_drugs ON take_drug.drug_id = user_drugs.id) WHERE take_drug.user_id='$id' ORDER BY take_drug.take_id";
                }
                if($res_rel = $conn -> query($sql_rel)){
                    while($row_rel = $res_rel -> fetch_array(MYSQLI_ASSOC)){
                        echo"
                                <tr>
                                    <th>".$row_rel['take_id']."</th>";
                                    if($_SESSION['is_admin'])
                                    echo"<th>".$row_rel['user_name']." ".$row_rel['user_surname']."</th>";
                        echo"
                                    <th>".$row_rel['name']."</th>
                                    <th>".$row_rel['count']."</th>
                                    <th>".$row_rel['take_date']."</th>";
                            if($_SESSION['is_admin']){
                            echo "<th>
                                    <img style='border-radius: 20px; border: 1px solid black;'
                                    src='../../img/".$row_rel['user_img']."' width='40' height='40'>
                                    </th>";
                            }
                        echo"
                                </tr>";
                    }
                }
                $conn -> close();           
            ?>
        </table>
    <a href="logged.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Return</p>
            </div>
        </div>
    </a>
</body>    
</html> 
