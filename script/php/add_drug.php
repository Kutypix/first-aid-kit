<?php
    session_start();
    if(!isset($_SESSION["current_user"])) 
        header('Location: ../../index.html');
    else if($_SESSION['is_admin']==0)
        header('Location: logged.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>...::: Adding medicine :::...</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/add_drugs.css">
    <link rel="stylesheet" href="../../css/template.css">
    <link rel="icon" type="imge/x-icon" href="../../img/favicon/drug.png">
</head>
<body>
    <div id="head">
        <p>Form for adding drugs to the database</p>
    </div>
    <fieldset id="add_drug">
        <legend>Please complete the drug details</legend>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label> Drug name: </label>
            <input type="text" name="d_name" required>
            <br><br>
            <label> Expiration date: </label>
            <?php echo"<input type='date' name='d_date_exp' min='".date("Y-m-d")."' required>"?>
            <br><br>
            <label> Quantity: </label>
            <input type="number" name="d_count" min="1" required>
            <br><br>
            <label> Cost: </label>
            <input type="number" step=0.01 name="d_cost" min="1" required>
            <br><br>
            <label> Comments/additional information: </label>
            <textarea name="d_description"></textarea>
            <br><br>
            <input class="bt" type="reset" value="Clear">
            <input class="bt" type="submit" value="Add">
        </form>
        <?php
            $conn = new mysqli($_SESSION['server_name'], $_SESSION['user_name'],$_SESSION['password'], $_SESSION['db_name']);
            $name = @$conn -> real_escape_string($_POST["d_name"]);
            $date = @$_POST["d_date_exp"];
            $count = @$_POST["d_count"];
            $cost = @$_POST["d_cost"];
            $desc = @$conn -> real_escape_string($_POST["d_description"]);
            if($name && $date && $count && $cost && $desc){
                $sql = "INSERT INTO apteczka_drugs(drug_name, drug_date, drug_count, drug_cost, drug_description) VALUES ('$name', '$date', '$count', '$cost', '$desc')";
                if($res = $conn -> query($sql))
                    echo "<p class='alert1'> The drug has been added successfully </p>";
                else if($conn -> connect_error)
                    echo "<p class='alert2'> An error occurred while adding the drug </p>";
                else{}
            }
            $conn -> close();
        ?>
    </fieldset>
    <a href="logged.php">
        <div class="outer_bt">
            <div class="bt">
                <p style="margin: auto;">Return</p>
            </div>
        </div>
    </a>
</body>    
</html> 