<?php
    session_start();
    if(!isset($_SESSION["current_user"])) 
            header('Location: ../../index.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>...::: Orders :::...</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/order.css">
    <link rel="stylesheet" href="../../css/template.css">
    <link rel="icon" type="imge/x-icon" href="../../img/favicon/drug.png">
</head>
<body>
<div id="head">
        <p>List of available drugs</p>
    </div>
    <form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Description</th>
                <th>Expiration date</th>
                <th>Action</th>
            </tr>
            <?php
            // wypisywanie dostenych leków które można dodać do apteczki
                $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'],$_SESSION['password'], $_SESSION['db_name']);
                $sql = "SELECT * FROM apteczka_drugs";
                if($res = $conn -> query($sql)){
                    while($row = $res -> fetch_array(MYSQLI_ASSOC)){
                        // if expired, cannoct add
                        if($row['drug_date'] < date("Y-m-d"))
                            echo "<tr style='text-decoration: line-through; color : rgb(187, 23, 23);'>";
                        else
                            echo "<tr>";
                            echo "
                                <th>".$row['drug_id']."</th>
                                <th>".$row['drug_name']."</th>
                                <th>".$row['drug_count']."</th>
                                <th>".$row['drug_cost']."</th>
                                <th>".$row['drug_description']."</th>
                                <th>".$row['drug_date']."</th>";
                        if($row['drug_date'] < date("Y-m-d"))
                            echo "<th> X </th>";
                        else
                            echo "<th>
                                    <input type='checkbox' name='drugs[]' value='".$row['drug_id']."'>
                                </th>";
                            echo "</tr>";
                        }
                }
            ?>
        </table>
        <?php
        // multi checxbox 
        foreach(@$_POST['drugs'] as $value){
            $sql = "SELECT * FROM apteczka_drugs WHERE drug_id='$value'";
            if($res = $conn -> query($sql)){
                while($row = $res -> fetch_array(MYSQLI_ASSOC)){
                    $name = $row['drug_name'];
                    $id = $row['drug_id'];
                    $date = $row['drug_date'];
                    $count = $row['drug_count'];
                    $cost = $row['drug_cost'];
                    $desc = $row['drug_description'];
                    $us_id = $_SESSION["current_user"];
                    $today = date("Y-m-d");
                    $sql2 = "INSERT INTO user_drugs(`drug_id`,`name`, `date_exp`, `purchase_date`, `count`, `cost`, `descr`, `user_id`) 
                             VALUES ('$id', '$name', '$date', '$today', '$count', '$cost', '$desc', '$us_id')";
                    $res2 = $conn -> query($sql2);
                }
            }
        }
        // response
        if(isset($res2))
            echo "<p class='alert1'> Leki został dodane do apteczki. Liczba dodanych medykamentów : ".count($_POST['drugs'])." </p>";
        else if($conn -> connect_error)
            echo "<p class='alert2'> Wystąpił błąd podczas dodawania leków !</p>";
        else{}
        $conn -> close();
    ?>
        <input class="bt" type="submit" value="Add">
        <input class="bt" type="reset" value="Clear">
    </form>
    <a href="logged.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Return</p>
            </div>
        </div>
    </a>
</body>    
</html> 